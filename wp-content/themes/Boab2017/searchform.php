
<form role="search" method="get" action="<?=home_url( '/' );?>" class="search-form">
    <div class="form-group has-feedback">
        <label for="search" class="sr-only">Search</label>
        <input type="search" class="form-control" name="s" id="search" placeholder="search" value="<?=get_search_query()?>"">
        <span class="glyphicon glyphicon-search form-control-feedback"></span>
    </div>
</form>