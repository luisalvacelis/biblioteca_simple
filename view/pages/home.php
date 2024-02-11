<?php
if(isset($_POST['search'])){
    $item='l.name';
    $search = $_POST['search'];
    $books = FormsController::ctrlLoadTableHome($item,$search);
    echo '<script>
            if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
            }
         </script>';
}else{
    $books = FormsController::ctrlLoadTableHome(null,null);
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <form class="d-flex" method="post">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" name="search"
                    autocomplete="off">
                <button class="btn btn-outline-primary" type="submit">Buscar</button>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Biblioteca</th>
                        <th>Nombre</th>
                        <th>Autor</th>
                        <th>Descripción</th>
                        <th>Fecha Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $key => $value): ?>
                    <tr>
                        <td><?php echo $value["id"];?></td>
                        <td><?php echo $value["name_biblioteca"];?></td>
                        <td><?php echo $value["name_libro"];?></td>
                        <td><?php echo $value["autor"];?></td>
                        <td><?php echo $value["description"];?></td>
                        <td><?php echo $value["register_date"];?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>