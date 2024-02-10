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
                        <th>Acciones</th>
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
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <div class="px-1">
                                    <a href="index.php?url=edit&idbook=<?php echo $value["id"]; ?>"
                                        class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a>
                                </div>
                                <form method="post">
                                    <input type="hidden" value="<?php echo $value["id"]; ?>" name="idbook">
                                    <button type="submit" class="btn btn-danger"><i
                                            class="fa-solid fa-trash"></i></button>
                                    <?php
                                        //$delete=new ControllerForms();
								        //$delete -> ctrlDeleteUser();
							        ?>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>