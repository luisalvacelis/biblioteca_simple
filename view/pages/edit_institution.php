<?php
$id=null;
$institution=null;
if(isset($_GET['idinstitution'])){
    if($_GET['idinstitution'] !== null){
        $id=$_GET['idinstitution'];
        $institution=new Institution($id,null,null,null);
        $institution->searchByID();
    }
}
?>

<div class="d-flex justify-content-center align-items-center">
    <form method="post" class="w-100 mt-4" style="max-width: 500px;">
        <div class="modal-body">
            <h3 class="text-center">Modificación de Institución</h3>
            <div class="form-group">
                <input type="hidden" name="idinstitution" value="<?php echo $institution->getId(); ?>">
                <label for="name">Nombre de institución</label>
                <input type="text" class="form-control" aria-describedby="nameHelp" id="name" name="name"
                    autocomplete="off" required value="<?php echo $institution->getName(); ?>">
            </div>
            <div class="form-group">
                <label for="txtarea">Descripción</label>
                <textarea class="form-control" id="txtarea" rows="3"
                    name="description"><?php echo $institution->getDescription(); ?></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <a href="index.php?url=institutions" class="btn btn-secondary mt-2 mx-1">Cancelar</a>
            <button type="submit" class="btn btn-primary mt-2 mx-1">Actualizar</button>
        </div>
        <?php
        if(isset($_POST['idinstitution']) && isset($_POST['name']) && isset($_POST['description'])){
            $id=$_POST['idinstitution'];
            $name=$_POST['name'];
            $description=$_POST['description'];
            $institution=new Institution($id,$name,$description,null);
            if($institution->updateInstitution()){
                echo '<div class="alert alert-success mt-2 alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        Institución modificada con éxito!.
                    </div>
                    <script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        }
                    </script>';
            }else{
                echo '<div class="alert alert-danger mt-2 alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        Error: No se pudo modificar la institución.
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