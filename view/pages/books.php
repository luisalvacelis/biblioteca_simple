<?php
if(isset($_POST['search'])){
    $search = $_POST['search'];
    $books = FormsController::ctrlLoadTableBook($search);
    echo '<script>
            if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
            }
         </script>';
}else{
    $books = FormsController::ctrlLoadTableBook(null);
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
            <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#register_books">
                Nuevo
            </button>
            <?php
            if(isset($_POST['selectInstitution']) && isset($_POST['name']) && isset($_POST['author']) && isset($_POST['description'])){
                $idInstitution=$_POST['selectInstitution'];
                $name=$_POST['name'];
                $author=$_POST['author'];
                $description=$_POST['description'];
                
                $book=new Book(null,$idInstitution,$name,$author,$description,null);
                if($book->registerBook()){
                    echo '<div class="alert alert-success mt-2 alert-dismissible" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Libro registrado con éxito!.
                        </div>
                        <script>
                            if(window.history.replaceState){
                                window.history.replaceState(null,null,window.location.href);
                            }
                        </script>';
                }else{
                    echo '<div class="alert alert-danger mt-2 alert-dismissible" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            Error: No se pudo registrar el libro.
                        </div>
                        <script>
                            if(window.history.replaceState){
                                window.history.replaceState(null,null,window.location.href);
                            }
                        </script>';
                }
                $books = FormsController::ctrlLoadTableBook(null);
            }

            if(isset($_POST['idbook_delete'])){
                $idBook=null;
                if($_POST['idbook_delete'] !== null){
                    $idBook=$_POST['idbook_delete'];
                }
                $book=new Book($idBook,null,null,null,null,null);
                if($book->deleteBook()){
                    echo '<div class="alert alert-success alert-dismissible mt-2" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                Libro eliminado con éxito!.
                            </div>
                            <script>
                                if(window.history.replaceState){
                                    window.history.replaceState(null,null,window.location.href);
                                }
                            </script>';
                }else{
                        echo '<div class="alert alert-success alert-dismissible mt-2" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                Error: No se pudo eliminar el libro.
                            </div>
                            <script>
                                if(window.history.replaceState){
                                    window.history.replaceState(null,null,window.location.href);
                                }
                            </script>';
                }
                $books = FormsController::ctrlLoadTableBook(null);
            }
            ?>

            <div class="modal fade" id="register_books" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="register_booksLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="register_booksLabel">Registro de Libros</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="idinstitution">Seleccione Biblioteca</label>
                                    <select name="selectInstitution" id="idinstitution" class="form-select mb-3"
                                        required>
                                        <option value="-1" selected>Biblioteca Disponible</option>
                                        <?php
                                            $institution=new Institution(null,null,null,null);
                                            $result=$institution->loadTableInstitution();
                                            foreach($result as $key => $value){
                                                echo "<option value=".$value['id'].">".$value['name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nombre de libro</label>
                                    <input type="text" class="form-control" aria-describedby="nameHelp" id="name"
                                        name="name" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="author">Autor del libro</label>
                                    <input type="text" class="form-control" aria-describedby="nameHelp" id="author"
                                        name="author" autocomplete="off" required>
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
                        <th>Libro</th>
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
                        <td><?php 
                        $institution=new Institution($value["idBiblioteca"],null,null,null);
                        $institution->searchByID();
                        echo $institution->getName();
                        ?></td>
                        <td><?php echo $value["name"];?></td>
                        <td><?php echo $value["autor"];?></td>
                        <td><?php echo $value["description"];?></td>
                        <td><?php echo $value["register_date"];?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <div class="px-1">
                                    <a href="index.php?url=edit_book&idbook=<?php echo $value["id"]; ?>"
                                        class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a>
                                </div>
                                <form method="post">
                                    <input type="hidden" value="<?php echo $value["id"]; ?>" name="idbook_delete">
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