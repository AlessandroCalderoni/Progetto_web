<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./?env=user&op=homepage">Zona NERD</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            {if isset($old_search) eq true}
                {$old_s = $old_search}
            {else}
                {$old_s = ''}
            {/if}
            <form class="navbar-form navbar-right" method="get" action="./">
                <div class="form-group">
                    <input type="text" id="searchbox" placeholder="Cerca un utente" class="form-control" name="search" value="{$old_s}">
                    <input type="hidden" class="form-control" name="env" value="user">
                    <input type="hidden" class="form-control" name="op" value="search">
                </div>
                <button id="search-submit" type="submit" class="btn btn-success">Search</button>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</nav>

<div class="container-fluid" id="total-container"> <!-- container di tutto ciò che è tra la topbar e la bottombar -->
    <div class="row">