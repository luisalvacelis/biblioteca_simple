<?php
$id=null;
$book=null;
if(isset($_GET['idbook'])){
    if($_GET['idbook'] !== null){
        $id=$_GET['idbook'];
        $book=new Book($id,null,null,null,null,null);
        $book->searchByID();
    }
}
?>

<div class="d-flex justify-content-center align-items-center">
    <form method="post" class="w-100 mt-4" style="max-width: 500px;">
        <div class="modal-body">
            <h3 class="text-center">Modificación de Libro</h3>
            <div class="form-group">
                <label for="idinstitution">Seleccione Biblioteca</label>
                <select name="selectInstitution" id="idinstitution" class="form-select mb-3" required>
                    <option value="-1">Biblioteca Disponible</option>
                    <?php
                        $institution=new Institution(null,null,null,null);
                        $result=$institution->loadTableInstitution();
                        
                        foreach($result as $key => $value){
                            if($value['id'] === $book->getIdInstitution()){
                                echo "<option value=".$value['id']." selected>".$value['name']."</option>";
                            }else{
                                echo "<option value=".$value['id'].">".$value['name']."</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="hidden" name="idbook" value="<?php echo $book->getId(); ?>">
                <label for="name">Nombre de libro</label>
                <input type="text" class="form-control" aria-describedby="nameHelp" id="name" name="name"
                    autocomplete="off" required value="<?php echo $book->getName(); ?>">
            </div>
            <div class="form-group">
                <label for="name">Autor</label>
                <input type="text" class="form-control" aria-describedby="autorHelp" id="name" name="author"
                    autocomplete="off" required value="<?php echo $book->getAuthor(); ?>">
            </div>
            <div class="form-group">
                <label for="txtarea">Descripción</label>
                <textarea class="form-control" id="txtarea" rows="3"
                    name="description"><?php echo $book->getDescription(); ?></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <a href="index.php?url=books" class="btn btn-secondary mt-2 mx-1">Cancelar</a>
            <button type="submit" class="btn btn-primary mt-2 mx-1">Actualizar</button>
        </div>
        <?php
        if(isset($_POST['idbook']) && isset($_POST['selectInstitution']) && isset($_POST['name']) && isset($_POST['author']) && isset($_POST['description'])){
            $id=$_POST['idbook'];
            $idInstitution=$_POST['idinstitution'];
            $name=$_POST['name'];
            $author=$_POST['author'];
            $description=$_POST['description'];
            $book=new Book($id,$idInstitution,$name,$author,$description,null);
            if($book->updateBook()){
                echo '<div class="alert alert-success mt-2 alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        Libro modificado con éxito!.
                    </div>
                    <script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        }
                    </script>';
            }else{
                echo '<div class="alert alert-danger mt-2 alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        Error: No se pudo modificar el libro.
                    </div>
                    <script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        }
                    </script>';
            }
        }
        ?>
    </form>
</div>