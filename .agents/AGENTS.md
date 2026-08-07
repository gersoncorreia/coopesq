# Workspace Guidelines & Clean Code Rules

## 1. Arquitetura Modular & Componentização (Regra das ~150 Linhas)
- **Limite Máximo por Arquivo**: Nenhum arquivo do projeto (Vue, JavaScript, PHP, CSS) deve ultrapassar aproximadamente **150 linhas de código**.
- **Decomposição Obrigatória**: Quando uma página, componente ou controlador começar a se aproximar do limite de 150 linhas, ele DEVE ser fragmentado em submódulos ou componentes filhos com responsabilidade única (Single Responsibility Principle).
- **Sem Arquivos Monolíticos**: Páginas principais de SPA (Views/Pages) devem atuar estritamente como orquestradoras, importando componentes limpos e especializados sob `resources/js/Components/`.
