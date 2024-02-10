<?php
if(isset($_POST['search'])){
    $search = $_POST['search'];
    $institutions = FormsController::ctrlLoadTableInstitution($search);
    echo '<script>
            if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
            }
         </script>';
}else{
    $institutions = FormsController::ctrlLoadTableInstitution(null);
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
            <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#register_institutions">
                Nuevo
            </button>
            <?php
            if(isset($_POST['name']) && isset($_POST['description'])){
                $name=$_POST['name'];
                $description=$_POST['description'];
                
                $institution=new Institution(null,$name,$description,null);
                if($institution->registerInstitution()){
                    echo '<div class="alert alert-success mt-2 alert-dismissible" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Institución registrada con éxito!.
                        </div>
                        <script>
                            if(window.history.replaceState){
                                window.history.replaceState(null,null,window.location.href);
                            }
                        </script>';
                }else{
                    echo '<div class="alert alert-danger mt-2 alert-dismissible" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Error: No se pudo registrar la institución.
                        </div>
                        <script>
                            if(window.history.replaceState){
                                window.history.replaceState(null,null,window.location.href);
                            }
                        </script>';
                }
                $institutions = FormsController::ctrlLoadTableInstitution(null);
            }

            if(isset($_POST['idinstitution_delete'])){
                $idInstitution=null;
                if($_POST['idinstitution_delete'] !== null){
                    $idInstitution=$_POST['idinstitution_delete'];
                }
                $institution=new Institution($idInstitution,null,null,null);
                if($institution->deleteInstitution()){
                    echo '<div class="alert alert-success alert-dismissible mt-2" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                Institución eliminada con éxito!.
                            </div>
                            <script>
                                if(window.history.replaceState){
                                    window.history.replaceState(null,null,window.location.href);
                                }
                            </script>';
                }else{
                        echo '<div class="alert alert-success alert-dismissible mt-2" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                Error: No se pudo eliminar la institución.
                            </div>
                            <script>
                                if(window.history.replaceState){
                                    window.history.replaceState(null,null,window.location.href);
                                }
                            </script>';
                }
                $institutions = FormsController::ctrlLoadTableInstitution(null);
            }
            ?>

            <div class="modal fade" id="register_institutions" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="register_institutionsLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="register_institutionsLabel">Registro de Instituciones</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Nombre de institución</label>
                                    <input type="text" class="form-control" aria-describedby="nameHelp" id="name"
                                        name="name" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="txtarea">Descripción</label>
                                    <textarea class="form-control" id="txtarea" rows="3" name="description"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Biblioteca</th>
                        <th>Descripción</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($institutions as $key => $value): ?>
                    <tr>
                        <td><?php echo $value["id"];?></td>
                        <td><?php echo $value["name"];?></td>
                        <td><?php echo $value["description"];?></td>
                        <td><?php echo $value["register_date"];?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <div class="px-1">
                                    <a href="index.php?url=edit_institution&idinstitution=<?php echo $value["id"]; ?>"
                                        class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a>
                                </div>
                                <form method="post">
                                    <input type="hidden" value="<?php echo $value["id"]; ?>"
                                        name="idinstitution_delete">
                                    <button type="submit" class="btn btn-danger"><i
                                            class="fa-solid fa-trash"></i></button>
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