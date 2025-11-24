## 📘 CheckCar-WEB

Sistema web para gerenciamento de checklists de veículos, incluindo cadastro de usuários, veículos, perguntas e respostas. Desenvolvido em PHP + MySQL, com interface padronizada e estilizada em HTML/CSS.

### 🚀 Funcionalidades
- Usuários

- Cadastro, edição e exclusão de usuários

- Listagem com tabela padronizada

- Veículos

- Cadastro de veículos (placa, tipo, marca, modelo, ano)

- Edição e exclusão

- Listagem com contagem total

- Perguntas

- Cadastro de perguntas para checklist

- Edição e exclusão

- Listagem com tabela

- Checklists

- Registro de respostas vinculadas a usuário, veículo e pergunta

- Visualização de checklists realizados

- Edição de checklist (alterar placa, tipo, observação)

- Exclusão de checklist por lote

## 🗂️ Estrutura de Pastas
```
CheckCar-Web-main/
│
├── actions/                # Scripts PHP para salvar, editar e excluir
│   ├── editar_usuario.php
│   ├── editar_veiculo.php
│   ├── editar_checklist.php
│   ├── excluir_usuario.php
│   ├── excluir_checklist.php
│   └── salvarVeiculo.php (se usado)
│
├── assets/
│   ├── css/
│   │   ├── style2.css
│   │   └── style3.css
│   └── img/
│       ├── logo_novo.png
│       ├── logoo.png
│       └── teste.png
│
├── includes/
│   └── conexao.php         # Conexão com banco MySQL
│
├── checklist.php           # Página principal de checklists
├── usuario.php             # Página de usuários
├── veiculo.php             # Página de veículos
├── perguntas.php           # Página de perguntas
└── README.md               # Documentação do projeto
```
## 🛠️ Tecnologias Utilizadas
- Backend: PHP 8+

- Banco de Dados: MySQL (MariaDB)

- Frontend: HTML5, CSS3

- Bibliotecas: Font Awesome para ícones

## ⚙️ Instalação e Configuração
- Clone o repositório:

```
git clone https://github.com/seuusuario/CheckCar-Web.git
```


- Crie o banco de dados no MySQL:

```
CREATE DATABASE checkcar;
USE checkcar;
```
- Importe as tabelas (exemplo):

```
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cpf VARCHAR(20),
    senha VARCHAR(255),
    tipo ENUM('ADMIN','USER')
);

CREATE TABLE veiculo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    placa VARCHAR(10),
    tipo VARCHAR(20),
    marca VARCHAR(50),
    modelo VARCHAR(50),
    ano INT
);

CREATE TABLE pergunta_checklist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto VARCHAR(255)
);

CREATE TABLE resposta_checklist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_lote INT NOT NULL,
    id_usuario INT NOT NULL,
    id_veiculo INT NOT NULL,
    tipo ENUM('CARRO','MOTO','CAMINHAO') NOT NULL,
    id_pergunta INT NOT NULL,
    observacao TEXT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id),
    FOREIGN KEY (id_veiculo) REFERENCES veiculo(id),
    FOREIGN KEY (id_pergunta) REFERENCES pergunta_checklist(id)
);

```
- Configure a conexão no arquivo includes/conexao.php:
```
php
<?php
$conn = new mysqli("localhost", "root", "", "checkcar");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
```
- Acesse no navegador:

```
http://localhost/CheckCar-Web-main/checklist.php
```
## 📋 Fluxo de Uso
- Usuários → cadastre os usuários que vão realizar checklists.

- Veículos → cadastre os veículos com placa, modelo e ano.

- Perguntas → defina as perguntas que serão usadas nos checklists.

- Checklists → visualize, edite ou exclua os checklists realizados.

## 🎨 Padrão Visual
- Header com logos e menu de navegação.

- Tabelas com cabeçalho escuro e linhas alternadas.

- Botões padronizados:

Azul → Editar (fa-pencil-alt)

Vermelho → Excluir (fa-trash)

Verde → Salvar (fa-save)

## 🤝 Contribuição
- Faça um fork do projeto.

- Crie uma branch para sua feature:

```
git checkout -b minha-feature
```
- Commit suas alterações:

```
git commit -m "Adiciona nova feature"
```
- Envie para sua branch:

```
git push origin minha-feature
```
- Abra um Pull Request.
