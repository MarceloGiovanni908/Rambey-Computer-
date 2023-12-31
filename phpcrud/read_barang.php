<?php
include '../koneksi.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;


// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM barang ORDER BY id_barang LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$barang = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_barang = $pdo->query('SELECT COUNT(*) FROM barang')->fetchColumn();
?>


<?=template_header('Read')?>

<div class="content read">
	<h2>Read Barang</h2>
	<a href="create_barang.php" class="create-contact">Add Barang</a>
	<table>
        <thead>
            <tr>
                <td>id_barang</td>
                <td>nama_barang</td>
                <td>merek</td>
                <td>img</td>
                <td>kategori</td>
                <td>harga</td>
                <td>hargaint</td>
                <td></td>
                <td></td>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($barang as $barang): ?>
            <tr>
                <td><?=$barang['id_barang']?></td>
                <td><?=$barang['nama_barang']?></td>
                <td><?=$barang['merek']?></td>
                <td><?=$barang['img']?></td>
                <td><?=$barang['kategori']?></td>
                <td><?=$barang['harga']?></td>
                <td><?=$barang['hargaint']?></td>
                <td class="actions">
                    <a href="update_barang.php?id_barang=<?=$barang['id_barang']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete_barang.php?id_barang=<?=$barang['id_barang']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read_barang.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_barang): ?>
		<a href="read_barang.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>