<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Garante que apenas administradores tenham acesso à gestão de usuários
     */
    private function authorizeAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403, 'Acesso restrito ao Administrador.');
    }

    /**
     * Lista todos os usuários cadastrados com busca e filtros
     */
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $busca = $request->query('busca');
        $status = $request->query('status');
        $role = $request->query('role');

        $query = User::query()->latest('created_at');

        if ($busca) {
            $term = '%'.trim($busca).'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term);
            });
        }

        if ($status !== null && $status !== 'todos') {
            $query->where('is_active', $status === 'ativo' ? 1 : 0);
        }

        if ($role && $role !== 'todos') {
            $query->where('role', $role);
        }

        $users = $query->paginate(15)->withQueryString();

        $allUsers = User::all();
        $stats = [
            'total' => $allUsers->count(),
            'ativos' => $allUsers->where('is_active', true)->count(),
            'bloqueados' => $allUsers->where('is_active', false)->count(),
            'admins' => $allUsers->filter(fn ($u) => $u->isAdmin())->count(),
            'clientes' => $allUsers->where('role', 'cliente')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats', 'busca', 'status', 'role'));
    }

    /**
     * Formulário para cadastrar novo usuário
     */
    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.users.create');
    }

    /**
     * Armazena um novo usuário criado pelo administrador
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:180', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,cliente'],
            'is_active' => ['required', 'boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => (bool) $validated['is_active'],
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Usuário '{$user->name}' cadastrado com sucesso!");
    }

    /**
     * Formulário de edição de usuário
     */
    public function edit(User $user)
    {
        $this->authorizeAdmin();

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Atualiza dados do usuário
     */
    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:180', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,cliente'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Proteção do Master Admin
        if ($user->isMasterAdmin()) {
            $validated['role'] = 'admin';
            $validated['is_active'] = 1;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->is_active = (bool) $validated['is_active'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', "Usuário '{$user->name}' atualizado com sucesso!");
    }

    /**
     * Alterna o status entre Ativo e Bloqueado
     */
    public function toggleStatus(User $user)
    {
        $this->authorizeAdmin();

        if ($user->isMasterAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'O Administrador Master da FOCO não pode ser bloqueado.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Você não pode bloquear o seu próprio usuário em sessão.');
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        $statusNome = $user->is_active ? 'LIBERADO (Ativo)' : 'BLOQUEADO';

        return redirect()->route('admin.users.index')
            ->with('success', "Usuário '{$user->name}' agora está {$statusNome}.");
    }

    /**
     * Remove o usuário do sistema
     */
    public function destroy(User $user)
    {
        $this->authorizeAdmin();

        if ($user->isMasterAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'O Administrador Master da FOCO não pode ser excluído.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Você não pode excluir o seu próprio usuário em sessão.');
        }

        $nome = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Usuário '{$nome}' excluído com sucesso.");
    }
}
