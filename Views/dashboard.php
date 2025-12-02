<?php
// dashboard_dark.php

$metrics = [
    'revenue' => 12850.75,
    'active_users' => 3421,
    'new_signups' => 128,
    'errors' => 7,
];

$last7 = [
    ['day' => date('d M', strtotime('-6 days')), 'value' => 9800],
    ['day' => date('d M', strtotime('-5 days')), 'value' => 10200],
    ['day' => date('d M', strtotime('-4 days')), 'value' => 11100],
    ['day' => date('d M', strtotime('-3 days')), 'value' => 12150],
    ['day' => date('d M', strtotime('-2 days')), 'value' => 12500],
    ['day' => date('d M', strtotime('-1 days')), 'value' => 12700],
    ['day' => date('d M'), 'value' => 12850],
];

$users = [
    ['id' => 1, 'name' => 'Ana Silva', 'email' => 'ana@example.com', 'role' => 'Admin', 'last_login' => '2025-11-30'],
    ['id' => 2, 'name' => 'Bruno Costa', 'email' => 'bruno@example.com', 'role' => 'Editor', 'last_login' => '2025-11-29'],
    ['id' => 3, 'name' => 'Carla Souza', 'email' => 'carla@example.com', 'role' => 'Viewer', 'last_login' => '2025-11-29'],
    ['id' => 4, 'name' => 'Diego Ramos', 'email' => 'diego@example.com', 'role' => 'Editor', 'last_login' => '2025-11-28'],
];

function money($n) {
    return 'R$ ' . number_format($n, 2, ',', '.');
}

?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard Dark — Demo</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root{
            --bg: #0b0f14;
            --panel: #0f1720;
            --muted: #9aa4b2;
            --accent: #7c3aed;
            --accent-2: #06b6d4;
            --glass: rgba(255,255,255,0.03);
            --radius: 12px;
        }
        *{box-sizing: border-box;font-family: Inter, ui-sans-serif, system-ui}
        body{margin:0;background:linear-gradient(180deg,var(--bg),#07101a);color:#e6eef6}

        .app{display:flex;min-height:100vh}
        .sidebar{width:260px;padding:20px;background:linear-gradient(180deg,var(--panel),rgba(10,14,18,0.7));border-right:1px solid rgba(255,255,255,0.03)}
        .main{flex:1;padding:24px}

        .brand{display:flex;align-items:center;gap:12px;margin-bottom:18px}
        .logo{width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,var(--accent),var(--accent-2));display:flex;align-items:center;justify-content:center;font-weight:700;color:#021}

        .nav a{display:block;padding:10px;border-radius:10px;color:var(--muted);text-decoration:none;margin-bottom:6px}
        .nav a.active{background:var(--glass);color:#fff}

        .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px}
        .search{background:rgba(255,255,255,0.03);padding:8px 12px;border-radius:10px;display:flex;gap:10px}

        input.search-input{background:transparent;border:none;outline:none;color:#cfe7ff}

        .grid{display:grid;grid-template-columns:repeat(12,1fr);gap:18px}
        .col-3{grid-column:span 3}
        .col-4{grid-column:span 4}
        .col-6{grid-column:span 6}

        .panel{background:rgba(255,255,255,0.02);padding:16px;border-radius:var(--radius);border:1px solid rgba(255,255,255,0.02)}

        .metric{display:flex;flex-direction:column}
        .metric .title{font-size:12px;color:var(--muted)}
        .metric .value{font-size:20px;font-weight:700;margin-top:6px}

        table{width:100%;border-collapse:collapse}
        th,td{padding:10px;text-align:left;border-bottom:1px solid rgba(255,255,255,0.02);font-size:14px}
        th{color:var(--muted);font-weight:600}

        @media (max-width:900px){
            .sidebar{display:none}
            .grid{grid-template-columns:repeat(6,1fr)}
            .col-3,.col-4,.col-6{grid-column:span 6}
        }

        .muted{color:var(--muted);font-size:13px}
        .spaced{display:flex;justify-content:space-between;align-items:center}
    </style>
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand">
            <div class="logo">D</div>
            <div>
                <h1>Dash Dark</h1>
                <div class="muted">Painel de controle</div>
            </div>
        </div>
        <nav class="nav">
            <a href="#" class="active">Visão geral</a>
            <a href="#">Usuários</a>
            <a href="#">Relatórios</a>
            <a href="#">Configurações</a>
        </nav>
    </aside>

    <main class="main">

        <div class="topbar">
            <div class="search">
                <input class="search-input" placeholder="Pesquisar..." />
            </div>
            <div class="muted">Olá, Admin</div>
        </div>

        <section class="grid">

            <div class="col-3 panel">
                <div class="metric">
                    <div class="title">Receita (Mês)</div>
                    <div class="value"><?= money($metrics['revenue']) ?></div>
                </div>
            </div>

            <div class="col-3 panel">
                <div class="metric">
                    <div class="title">Usuários Ativos</div>
                    <div class="value"><?= number_format($metrics['active_users']) ?></div>
                </div>
            </div>

            <div class="col-3 panel">
                <div class="metric">
                    <div class="title">Erros (hoje)</div>
                    <div class="value"><?= $metrics['errors'] ?></div>
                </div>
            </div>

            <div class="col-3 panel">
                <div class="metric">
                    <div class="title">SLA</div>
                    <div class="value">99.98%</div>
                </div>
            </div>

            <!-- 🎯 PAINEL DO GRÁFICO CORRIGIDO -->
            <div class="col-6 panel" style="height:340px">
                <div class="spaced" style="margin-bottom:10px">
                    <strong>Receita (últimos 7 dias)</strong>
                    <div class="muted">Atualizado: <?= date('d/m/Y H:i') ?></div>
                </div>

                <!-- Canvas sem height infinito -->
                <canvas id="chartRevenue" style="width:100%;height:100%;"></canvas>
            </div>

            <div class="col-6 panel">
                <strong>Usuários recentes</strong>
                <div class="muted">Total: <?= count($users) ?></div>
                <div style="overflow:auto;max-height:260px">
                    <table>
                        <thead>
                            <tr><th>ID</th><th>Nome</th><th>E-mail</th><th>Função</th><th>Último login</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $u): ?>
                                <tr>
                                    <td><?= htmlspecialchars($u['id']) ?></td>
                                    <td><?= htmlspecialchars($u['name']) ?></td>
                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                    <td><?= htmlspecialchars($u['role']) ?></td>
                                    <td><?= htmlspecialchars($u['last_login']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </main>
</div>

<script>
const last7 = <?= json_encode($last7) ?>;

const labels = last7.map(x => x.day);
const values = last7.map(x => x.value);

const ctx = document.getElementById('chartRevenue');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Receita (R$)',
            data: values,
            tension: 0.3,
            fill: true,
            backgroundColor: 'rgba(124,58,237,0.12)',
            borderColor: 'rgba(124,58,237,0.9)',
            pointRadius: 4,
            pointBackgroundColor: 'rgba(124,58,237,1)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks:{ color:'#a8c0d8' }, grid:{ display:false } },
            y: { ticks:{ color:'#a8c0d8' }, grid:{ color:'rgba(255,255,255,0.03)' } }
        }
    }
});
</script>

</body>
</html>
