<form action="galeria.php?cmd=add_dir" method="post" class="col-md-6">
    <div class="input-group mb-0 col-md-6">

        <div class="input-group-text">
            <input class="form-check-input mt-0" type="checkbox" name="dat" value="yes" aria-label="Checkbox for following text input" checked>
        </div>
       
        <input type="text" name="add_dir" class="form-control" required placeholder="Podaj nazwę folderu"/>
        <input type="submit" class="btn btn-dark" value="Dodaj folder galerii">

    </div>
    <small>Zaznacz jeśli nazwa folderu ma zaczynać się bieżącą datą</small>
    <input type="hidden" name="add" value="add" />

</form>
<hr>