<nav class="navbar navbar-expand-md navbar-dark bg-dark" style="margin-bottom: 20px">
    <a class="navbar-brand" href="/"><img src="/images/logo.png" style="max-width: 70px" class="img-fluid logo" alt="{{config('app.name', 'AltHealth')}}" /></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Dashboard <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/clients">Clients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/suppliers">Suppliers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/supplements">Supplements</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/invoices">Invoices</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/cart">Cart</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reports
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/reports/d2d-1">Unpaid Invoices</a>
                    <a class="dropdown-item" href="/reports/d2d-2">Client Birthdays</a>
                    <a class="dropdown-item" href="/reports/d2d-3">Insufficient Stock</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/reports/mis-1">Top 10 Clients</a>
                    <a class="dropdown-item" href="/reports/mis-2">Monthly Sales</a>
                    <a class="dropdown-item" href="/reports/mis-3">Client Contact</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
