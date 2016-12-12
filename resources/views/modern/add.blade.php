<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Add account first<br />
					<form method="post" action="http://localhost/instalike/public/add">
					{{ csrf_field() }}
					Username: <input type="text" name="uname"><br>
					Password: <input type="password" name="pass"><br>
					<input type="submit" value="Login">
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
