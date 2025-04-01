<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$pageTitle = "Dashboard";
include 'includes/header.php'; // Certifique-se de que o arquivo existe
?>

<div class="dashboard">
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Gerenciador Chatbot</h2>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li class="active"><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="pages/perguntas/listar.php" target="_blank"><i class="fas fa-question-circle"></i> Perguntas</a></li>
                <li><a href="pages/palavras-chave/listar.php" target="_blank"><i class="fas fa-key"></i> Palavras-chave</a></li>
                
                <?php if (isAdmin()): ?>
                    <li class="menu-divider">Administração</li>
                    <li><a href="#" target="_blank"><i class="fas fa-users"></i> Usuários</a></li>
                    <li><a href="#" target="_blank"><i class="fas fa-cog"></i> Configurações</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    
    <div class="main-content">
        <header class="main-header">
            <div class="header-left">
                <button class="toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>Dashboard</h1>
            </div>
            
            <div class="header-right">
                <div class="user-dropdown">
                    <button class="user-btn">
                        <span class="user-avatar"><?= substr($_SESSION['user_name'], 0, 1) ?></span>
                        <span class="user-name"><?= $_SESSION['user_name'] ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    
                    <div class="dropdown-menu">
                        <a href="#"><i class="fas fa-user"></i> Perfil</a>
                        <a href="#"><i class="fas fa-cog"></i> Configurações</a>
                        <div class="dropdown-divider"></div>
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    </div>
                </div>
            </div>
        </header>
        
        <main class="content">
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Perguntas</h3>
                        <p><?= $pdo->query("SELECT COUNT(*) FROM perguntas_respostas")->fetchColumn() ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Palavras-chave</h3>
                        <p><?= $pdo->query("SELECT COUNT(*) FROM palavras_chave")->fetchColumn() ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Usuários</h3>
                        <p><?= $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn() ?></p>
                    </div>
                </div>
            </div>
            
            <div class="recent-questions">
                <div class="card">
                    <div class="card-header">
                        <h2>Perguntas Recentes</h2>
                        <a href="pages/perguntas/adicionar.php" class="btn btn-sm btn-primary">Adicionar Nova</a>
                    </div>
                    
                    <div class="card-body">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pergunta</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $perguntas = $pdo->query("SELECT * FROM perguntas_respostas ORDER BY id DESC LIMIT 5")->fetchAll();
                                foreach ($perguntas as $pergunta):
                                ?>
                                <tr>
                                    <td><?= $pergunta['id'] ?></td>
                                    <td><?= substr($pergunta['pergunta'], 0, 50) ?>...</td>
                                    <td>
                                        <?= isset($pergunta['data_envio']) ? date('d/m/Y', strtotime($pergunta['data_envio'])) : 'Data não disponível' ?>
                                    </td>
                                    <td>
                                        <!-- Ações removidas -->
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; // Certifique-se de que o arquivo existe ?>