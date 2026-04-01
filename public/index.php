<?php
//include
include '../config/koneksi.php';

$guru = mysqli_query($conn, "SELECT * FROM guru ORDER BY nama ASC");

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $instansi = $_POST['instansi'];
    $no_hp = $_POST['no_hp'];
    $guru_id = $_POST['guru_id'];
    $keperluan = $_POST['keperluan'];

    mysqli_query($conn, "INSERT INTO tamu 
        (nama, instansi, no_hp, guru_id, keperluan) 
        VALUES 
        ('$nama','$instansi','$no_hp','$guru_id','$keperluan')");

    $id_tamu = mysqli_insert_id($conn);

    echo "
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        showReviewModal($id_tamu);
    });
    </script>
    ";
}
      $review = mysqli_query($conn,
      "SELECT r.*, t.nama 
      FROM review r
      JOIN tamu t ON r.tamu_id = t.id
      WHERE r.status='approved'
      ORDER BY r.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Buku Tamu Digital</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../assets/vendor/css/core.css" />
<link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  scroll-behavior: smooth;
  background: radial-gradient(circle at 20% 30%, #ffd6a5, transparent 40%),
              radial-gradient(circle at 80% 70%, #b8c0ff, transparent 40%),
              #f5f7ff;
}

/* HERO */
.hero {
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 40px;
}

.hero h1 {
  font-size: 64px;
  font-weight: 800;
  color: #111827;
}

.hero p {
  font-size: 20px;
  color: #6b7280;
  margin-top: 20px;
  max-width: 700px;
  margin-left: auto;
  margin-right: auto;
}

.scroll-text {
  margin-top: 40px;
  font-size: 14px;
  color: #9ca3af;
}

/* FORM SECTION */
.form-section {
  min-height: 100vh;
  padding: 120px 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.form-card {
  width: 100%;
  max-width: 650px;
  border-radius: 24px;
  backdrop-filter: blur(12px);
  background: rgba(255,255,255,0.85);
  border: 1px solid rgba(255,255,255,0.4);
  box-shadow: 0 20px 60px rgba(0,0,0,0.08);
  transition: 0.3s ease;
  padding:40px;
}

.form-card:hover {
  transform: translateY(-5px);
}

/* INPUT */
.form-control,
textarea {
  border-radius: 14px !important;
  border: 1px solid #e5e7eb !important;
  padding: 14px 16px !important;
  transition: all 0.3s ease;
  background: rgba(255,255,255,0.9);
}

.form-control:focus,
textarea:focus {
  border-color: #6366f1 !important;
  box-shadow: 0 0 0 3px rgba(99,102,241,0.2) !important;
}

label {
  font-weight: 600;
  margin-bottom: 6px;
  color: #374151;
}

.btn-primary {
  border-radius: 14px !important;
  padding: 14px;
  font-weight: 600;
  font-size: 16px;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  border: none;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(99,102,241,0.4);
}

/* SELECT2 */
.select2-container--default .select2-selection--single {
    height: 48px !important;
    border-radius: 14px !important;
    padding: 10px !important;
}
.select2-selection__rendered {
    line-height: 28px !important;
}

/* REVIEW */
.star {
    font-size: 32px;
    cursor: pointer;
    color: #e5e7eb; /* abu default */
    transition: 0.3s;
}

.star.active {
    color: #facc15; /* kuning */
    transform: scale(1.2);
}
.tag-btn { 
    margin:5px; 
    padding:8px 15px;  
    border:none; 
    border-radius:20px; 
    background:#e5e7eb; 
    cursor:pointer; }
.tag-btn.active { 
    background:#6366f1; 
    color:white; }
#kirimReview { 
    padding:8px 20px; 
    border:none; 
    border-radius:20px; 
    background:#6366f1; 
    color:white; }
#kirimReview:disabled { 
    background:gray; }
#skipReview { 
    padding:8px 20px; 
    border:none; 
    border-radius:20px; 
    background:#ccc; }
.review-section {
    padding: 100px 20px;
    background: #ffffff;
}

.review-wrapper {
    overflow: hidden;
    position: relative;
}

.review-track {
    display: flex;
    gap: 20px;
    animation: scrollReview 100s linear infinite;
}

.review-card {
    min-width: 260px;
    background: white;
    padding: 20px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    transition: 0.3s ease;
}

.review-card:hover {
    transform: translateY(-6px);
}

.review-name {
    font-weight: 600;
    margin-bottom: 8px;
}

.review-rating .star {
    color: #facc15;
}

.review-rating .empty {
    color: #e5e7eb;
}

.review-text {
    margin-top: 10px;
    font-size: 14px;
    color: #555;
}

@keyframes scrollReview {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
</style>
</head>

<body>

<section class="hero">
  <div>
    <h1>Modernisasi Pencatatan <br>Buku Tamu Sekolah.</h1>
    <p>
      Buku Tamu Digital adalah solusi berbasis web untuk mencatat 
      kunjungan secara cepat, rapi, dan profesional.
    </p>
    <div class="scroll-text">⬇ Scroll ke bawah untuk mengisi data</div>
  </div>
</section>

<section class="form-section">
<div class="form-card">

<h4 class="fw-bold mb-4 text-center">Form Kunjungan</h4>

<form method="POST">

<div class="mb-3">
<label>Nama Tamu</label>
<input type="text" name="nama" class="form-control" required>
</div>

<div class="mb-3">
<label>Instansi</label>
<input type="text" name="instansi" class="form-control">
</div>

<div class="mb-3">
<label>No HP</label>
<input type="text" name="no_hp" class="form-control" required>
</div>

<div class="mb-3">
<label>Menemui</label>
<select name="guru_id" id="guruSelect" class="form-control" required>
<option value="">-- Pilih Guru --</option>
<?php while($g = mysqli_fetch_assoc($guru)) : ?>
<option value="<?= $g['id']; ?>">
<?= $g['nama']; ?> - <?= $g['bidang']; ?>
</option>
<?php endwhile; ?>
</select>
</div>

<div class="mb-3">
<label>Keperluan</label>
<textarea name="keperluan" class="form-control" required></textarea>
</div>

<button type="submit" name="simpan" class="btn btn-primary w-100">
Kirim Data
</button>

</form>
</div>
</section>
<section class="review-section">

    <h3 class="text-center fw-bold mb-4">
        Apa Kata Pengunjung?
    </h3>

    <div class="review-wrapper">
        <div class="review-track">

            <?php while($r = mysqli_fetch_assoc($review)) : ?>

            <div class="review-card">
                <div class="review-name">
                    <?= $r['nama']; ?>
                </div>

                <div class="review-rating">
                    <?php
                    for($i=1;$i<=5;$i++){
                        if($i <= $r['rating']){
                            echo "<span class='star'>★</span>";
                        } else {
                            echo "<span class='star empty'>★</span>";
                        }
                    }
                    ?>
                </div>

                <div class="review-text">
                    <?= $r['tags']; ?>
                </div>
            </div>

            <?php endwhile; ?>

        </div>
    </div>

</section>
<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#guruSelect').select2({
        placeholder: "Pilih Guru yang Ditemui",
        allowClear: true,
        width: '100%'
    });
});


</script>
<script>
function showReviewModal(tamuId) {

let rating = 0;
let selectedTags = [];

const positiveTags = [
"Ramah","Cepat","Modern","Profesional",
"Informatif","Nyaman","Terorganisir","Canggih","Memuaskan"
];

const neutralTags = [
"Cukup Baik","Perlu Pengembangan","Masih Dapat Ditingkatkan"
];

const negativeTags = [
"Kurang Responsif","Lama","Kurang Informatif",
"Perlu Perbaikan","Kurang Nyaman"
];

function generateStars() {
    let stars = '';
    for(let i=1;i<=5;i++){
        stars += `<span class="star" data-value="${i}">⭐</span>`;
    }
    return stars;
}

function generateTags(tags){
    return tags.map(tag => 
        `<button type="button" class="tag-btn" data-tag="${tag}">${tag}</button>`
    ).join('');
}

Swal.fire({
    title: 'Data Kunjungan Anda Terkirim!',
    html: `
        <p>Berikan penilaian terhadap pelayanan kami</p>
        <div class="stars">${generateStars()}</div>
        <div id="tagContainer" class="tag-container"></div>
        <br>
        <button id="kirimReview" disabled>Kirim Review</button>
        <button id="skipReview">Lewati</button>
    `,
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => {

        const stars = document.querySelectorAll('.star');
        const tagContainer = document.getElementById('tagContainer');
        const kirimBtn = document.getElementById('kirimReview');
        const skipBtn = document.getElementById('skipReview');

        stars.forEach(star => {
            star.addEventListener('click', function(){
                rating = this.dataset.value;
                stars.forEach(s => s.style.opacity = 0.3);
                for(let i=0;i<rating;i++){
                    stars[i].style.opacity = 1;
                }

                if(rating >= 4){
                    tagContainer.innerHTML = generateTags(positiveTags);
                } else if(rating == 3){
                    tagContainer.innerHTML = generateTags(neutralTags);
                } else {
                    tagContainer.innerHTML = generateTags(negativeTags);
                }

                addTagListener();
                validate();
            });
        });

        function addTagListener(){
            document.querySelectorAll('.tag-btn').forEach(btn=>{
                btn.addEventListener('click', function(){
                    const tag = this.dataset.tag;
                    if(selectedTags.includes(tag)){
                        selectedTags = selectedTags.filter(t=>t!==tag);
                        this.classList.remove('active');
                    } else {
                        selectedTags.push(tag);
                        this.classList.add('active');
                    }
                    validate();
                });
            });
        }

        function validate(){
            kirimBtn.disabled = !(rating > 0 && selectedTags.length > 0);
        }

        kirimBtn.addEventListener('click', function(){
            fetch('simpan-review.php', {
                method: 'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: `tamu_id=${tamuId}&rating=${rating}&tags=${selectedTags.join(',')}`
            }).then(()=> {
                Swal.fire('Terima Kasih!', 'Review berhasil dikirim.', 'success')
                .then(()=> window.location='index.php');
            });
        });

        skipBtn.addEventListener('click', function(){
            window.location='index.php';
        });

    }
});
}
</script>
</body>
</html>
