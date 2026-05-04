<nav class="navbar">
    <div class="nav-brand">🎓 upgris Beasiswa</div>
    <ul class="nav-links">
        <li><a href="<?= BASE_URL ?>views/dashboard.php">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>views/siswa/index.php">Data Siswa</a></li>
        <li><a href="<?= BASE_URL ?>views/ranking/index.php">Ranking</a></li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <li><a href="<?= BASE_URL ?>views/setting/kuota.php">Pengaturan</a></li>
        <?php endif; ?>
        <li><a href="<?= BASE_URL ?>controllers/AuthController.php?action=logout" class="nav-logout">Logout (<?= htmlspecialchars($_SESSION['username'] ?? '') ?>)</a></li>
    </ul>
</nav>
