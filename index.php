<?php
require_once "controller/forms_controller.php";
require_once "controller/template_controller.php";
require_once "model/forms_model.php";
require_once "model/institution_model.php";
require_once "model/book_model.php";

$template=new TemplateController();
$template->getTemplate();