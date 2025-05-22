<?php

session_start();

// Simpan data ke session jika belum ada
if (!isset($_SESSION['todos'])) {
  $_SESSION['todos'] = [];
}

// Tambah todo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tugas'], $_POST['deadline'])) {
  $_SESSION['todos'][] = [
    'tugas' => $_POST['tugas'],
    'deadline' => $_POST['deadline'],
    'selesai' => false
  ];
  header('Location: index.php');
  exit();
}

// Tandai selesai
if (isset($_GET['selesai'])) {
  $_SESSION['todos'][$_GET['selesai']]['selesai'] = true;
  header('Location: index.php');
  exit();
}

// Hapus todo
if (isset($_GET['hapus'])) {
  array_splice($_SESSION['todos'], $_GET['hapus'], 1);
  header('Location: index.php');
  exit();
}

// Edit todo
if (isset($_POST['edit_index'])) {
  $_SESSION['todos'][$_POST['edit_index']]['tugas'] = $_POST['edit_tugas'];
  $_SESSION['todos'][$_POST['edit_index']]['deadline'] = $_POST['edit_deadline'];
  header('Location: index.php');
  exit();
}

$today = date('Y-m-d');
$searchKeyword = strtolower($_GET['search'] ?? '');
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ToDo List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-light min-vh-100">

  <a href="logout.php" class="btn btn-outline-danger position-absolute top-0 end-0 m-4 shadow">Logout</a>

  <div class="container py-5">
    <!-- Illustration -->
    <h2 id="judul-todolist" class="text-center text-success mb-1 fw-bold">
      <i class="bi bi-journal-text me-2"></i> ToDo List
    </h2>
    <p class="text-center text-muted mb-3">Organize your day, one task at a time.</p>
    <blockquote class="blockquote text-center mb-5">
      <p class="mb-0 fst-italic text-secondary">"The best way to get something done is to begin."</p>
    </blockquote>

    <!-- Form Pencarian -->
    <form method="GET" class="mb-4">
      <div class="input-group">
        <input type="text" name="search" class="form-control border-0 bg-white text-dark" placeholder="Cari todo..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" />
        <button class="btn btn-success" type="submit">Cari</button>
      </div>
    </form>

    <!-- Form Tambah -->
    <form method="POST" class="row g-3 mb-5 justify-content-center">
      <div class="col-md-7 col-sm-12">
        <input type="text" name="tugas" class="form-control border-0 bg-white text-dark" placeholder="Apa yang ingin kamu kerjakan?" required />
      </div>
      <div class="col-md-3 col-sm-6">
        <input type="date" name="deadline" class="form-control border-0 bg-white text-dark" required />
      </div>
      <div class="col-md-2 col-sm-6 d-grid">
        <button type="submit" class="btn btn-success">Tambah</button>
      </div>
    </form>

    <?php if (empty($_SESSION['todos'])): ?>
      <div class="alert alert-warning text-center shadow-sm">
        Belum ada tugas. Yuk, tambahkan tugas pertamamu hari ini!
      </div>
    <?php endif; ?>

    <?php foreach ($_SESSION['todos'] as $index => $todo):
      if ($searchKeyword && strpos(strtolower($todo['tugas']), $searchKeyword) === false) continue;
      $isLate = !$todo['selesai'] && $todo['deadline'] < $today;
      $cardClass = $todo['selesai'] ? 'bg-success bg-opacity-25 border-success' : ($isLate ? 'bg-warning bg-opacity-25 border-warning' : 'bg-white border-0');
      $textClass = $todo['selesai'] ? 'text-success' : ($isLate ? 'text-warning' : 'text-dark');
    ?>
      <div class="card mb-3 shadow-sm border <?= $cardClass ?>">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
          <div>
            <strong class="<?= $textClass ?>" <?= $todo['selesai'] ? 'style="text-decoration: line-through;"' : '' ?>>
              <?= htmlspecialchars($todo['tugas']) ?>
            </strong><br />
            <small class="text-muted">Deadline: <?= $todo['deadline'] ?></small>
            <?php if ($isLate): ?>
              <span class="badge bg-warning text-dark ms-2">Terlambat</span>
            <?php endif; ?>
          </div>
          <div class="btn-group" role="group" aria-label="Action buttons">
            <!-- Edit Button Trigger -->
            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $index ?>" aria-label="Edit">
              <i class="bi bi-pencil"></i>
            </button>
            <a href="?selesai=<?= $index ?>" class="btn btn-success btn-sm" aria-label="Mark as done">
              <i class="bi bi-check-lg"></i>
            </a>
            <a href="?hapus=<?= $index ?>" class="btn btn-danger btn-sm" aria-label="Delete">
              <i class="bi bi-trash"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Modal Edit -->
      <div class="modal fade" id="editModal<?= $index ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $index ?>" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST">
              <div class="modal-header bg-success bg-opacity-75 text-white">
                <h5 class="modal-title" id="editModalLabel<?= $index ?>">Edit Todo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body bg-light">
                <input type="hidden" name="edit_index" value="<?= $index ?>" />
                <div class="mb-3">
                  <label for="edit_tugas_<?= $index ?>" class="form-label">Tugas</label>
                  <input id="edit_tugas_<?= $index ?>" type="text" class="form-control bg-white text-dark" name="edit_tugas" value="<?= htmlspecialchars($todo['tugas']) ?>" required />
                </div>
                <div class="mb-3">
                  <label for="edit_deadline_<?= $index ?>" class="form-label">Deadline</label>
                  <input id="edit_deadline_<?= $index ?>" type="date" class="form-control bg-white text-dark" name="edit_deadline" value="<?= $todo['deadline'] ?>" required />
                </div>
              </div>
              <div class="modal-footer bg-success bg-opacity-10">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <!-- Footer -->
    <footer class="mt-5 pt-4 border-top text-center text-muted small">
      &copy; <?= date('Y') ?> ToDo Earthy. Made with <span class="text-danger">&hearts;</span>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
