# FOCO SINALIZAÇÃO E SISTEMAS INTELIGENTES LTDA
### Soluções Integradas em Mobilidade Urbana

Plataforma completa composta por **Site Institucional de Alto Impacto** (com efeitos 3D em Three.js, Parallax e portal público de chamados) e **Gerenciador Operacional** (painel administrativo com sidebar à esquerda, autenticação Laravel Breeze, controle de chamados viários, telemetria e emissão de Ordens de Serviço).

---

## 🚦 Visão Geral do Sistema

### 1. Site Institucional & Engenharia de Tráfego
* **Tecnologia Visual:** Desenvolvido em Tailwind CSS com **Three.js** para renderização 3D de malha viária, partículas de fluxo de tráfego, semáforo tridimensional com efeito de **Onda Verde** e micro-interações com **3D Tilt** nos cards.
* **Identidade Visual:** Paleta estrita alinhada ao logotipo oficial: Azul Marinho Noturno (`#020611`, `#061329`), Amarelo Semafórico (`#f59e0b`), Verde Semáforo (`#10b981`), Vermelho (`#ef4444`) e Ciano Inteligente (`#06b6d4`).
* **Narrativa Corporativa de Alto Impacto:**
  * **Nossa História:** Da infraestrutura crítica semafórica à engenharia avançada de tráfego.
  * **Quem Somos:** Atuação completa em software, hardware e sincronismo de vias urbanas e rodovias.
* **Os 5 Pilares Fundamentais:**
  1. *Engenharia e Infraestrutura Civil Viária* (Eletrodutos de PEAD, caixas de passagem e colunas/braços em aço galvanizado a fogo).
  2. *Inteligência de Tráfego Adaptativo (ITS)* (Câmeras HD com visão computacional, laços virtuais e contagem volumétrica contínua).
  3. *Central Semafórica WEB DIGICON em Nuvem Segura* (RBAC, Audit Trail criptografado, telemetria 4G/GPS e mitigação WAF/DDoS).
  4. *Ecossistema Mobile para Equipes de Campo* (App móvel para agentes de trânsito realizarem intervenções imediatas e receberem ordens georreferenciadas).
  5. *Autonomia Energética Híbrida* (Nobreak senoidal puro, bancos de baterias LiFePO4, captação solar fotovoltaica MPPT e microgeradores eólicos urbanos).
* **Matriz de Impacto e Resultados:** Tabela interativa comparativa (*Cenário Convencional* vs *Solução Inteligente FOCO*).
* **Presença Viária (+25 Municípios e Rodovias):**
  * Santa Catarina (Balneário Camboriú, Balneário Piçarras).
  * Rio Grande do Sul (19 municípios: Novo Hamburgo, Canoas, Passo Fundo, Torres, Tramandaí, etc.).
  * Rodovias Federais (BR 101, BR 116, BR 153, BR 290) com foco em obras temporárias de pontes e contenção de barreiras.
* **Parceiros Estratégicos:** Digicon S/A, Sinaway, Signasul, Contransin, Pavicon, Sinaltran, LCM Construtora, Chiorri e TR Sul.

---

### 2. Portal & Menu de Chamados no Site
* **Abertura de Chamados:** Interface intuitiva para órgãos públicos (DTT, Guarda de Trânsito, Secretarias de Obras), concessionárias e cidadãos registrarem ocorrências.
* **Preenchimento Rápido de Teste:** Botão com 1 clique para carregar dados fictícios realistas e testar instantaneamente.
* **Geração Automática de Protocolo:** Gera códigos oficiais no formato `FOC-2026-XXXX` com feedback animado de confetes.
* **Consulta de Protocolo & Rastreamento:** Timeline operacional de 4 etapas (*Registrado → Triagem Nuvem → Equipe Despachada → Concluído & Testado*).
* **Persistência de Dados Fakes:** Implementado com arquitetura desacoplada via `ChamadoService`, permitindo operar imediatamente sem migrations obrigatórias antes dos dados reais.

---

### 3. Gerenciador Operacional (Admin com Menu na Esquerda)
* **Sidebar Lateral na Esquerda:**
  * Exibição do logo oficial da Foco Sinalização.
  * Indicador de conexão e status em tempo real da nuvem DIGICON.
  * **Menu Obrigatório "Chamados"** com badge em tempo real de ocorrências em aberto.
  * Navegação rápida para: *Visão Geral (Dashboard)*, *Chamados*, *Controladores & ITS*, *Central DIGICON Nuvem*, *Municípios & Rodovias*, *Meu Perfil* e *Ver Site Público*.
* **Gestão de Chamados:**
  * Filtros dinâmicos por Status (*Aberto, Em Atendimento, Pendente Peça, Concluído*), Prioridade e Município.
  * Busca instantânea por protocolo, logradouro ou solicitante.
  * Detalhes do chamado com **Trilha de Auditoria Digital (Audit Trail)**.
  * Despacho técnico e alteração de status operacional.
  * **Emissão de Ordem de Serviço (O.S.):** Documento formatado pronto para impressão (`window.print()`) com checklist técnico em campo e campos de assinatura para o fiscal da prefeitura e engenheiro da Foco.
  * **Exportação CSV:** Exportação de todos os chamados compatível com Excel e Google Sheets.

---

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 8.5+ & Laravel 12
* **Autenticação:** Laravel Breeze (Stack Blade + Tailwind)
* **Banco de Dados:** MySQL
* **Frontend:** Tailwind CSS, Alpine.js, Three.js (3D WebGL), Canvas-Confetti
* **Bundler:** Vite

---

## 🚀 Instalação e Execução

### 1. Clonar o repositório
```bash
git clone https://github.com/RenanPiccinini/foco_sinalizacao.git
cd foco_sinalizacao
```

### 2. Instalar dependências PHP e Node
```bash
composer install
npm install
```

### 3. Configurar o arquivo de ambiente
```bash
cp .env.example .env
php artisan key:generate
```

Verifique se o banco MySQL está configurado no `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foco_sinalizacao
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Executar Migrações e Seeds
```bash
php artisan migrate --seed
```

### 5. Compilar os Assets
```bash
npm run build
```

### 6. Iniciar o Servidor
```bash
php artisan serve
```

Acesse:
* **Site Público:** [http://localhost:8000](http://localhost:8000)
* **Portal de Chamados:** [http://localhost:8000/chamados](http://localhost:8000/chamados)
* **Gerenciador Operacional:** [http://localhost:8000/dashboard](http://localhost:8000/dashboard)

---

## 🔐 Credenciais Padrão do Administrador

* **E-mail:** `admin@focosinalizacao.com.br`
* **Senha:** `admin1234`

*(A tela de login conta com botão de preenchimento automático para agilizar testes e demonstrações).*

---

## 🧪 Testes Automatizados

O projeto inclui suíte completa de testes com PHPUnit:
```bash
php artisan test
```
* Status: **28 testes aprovados / 86 asserções.**

---

© Foco Sinalização e Sistemas Inteligentes LTDA. Todos os direitos reservados.
