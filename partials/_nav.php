<?php 
    // session_start();

    if(isset($_SESSION['isLoggedIn']) || isset($_SESSION['isAdminLoggedIn'])){
        $loggedIn = true;
    }else{
        $loggedIn = false;
    }
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/ellipsonic"> To-Do List</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">';
                    if(!$loggedIn){
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="/ellipsonic/login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/ellipsonic/signup.php">Signup</a>
                            </li>';
                    }
                    if($loggedIn){
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="/ellipsonic/logout.php">Logout</a>
                            </li>';
                    }
                    
                    echo '
            </div>
        </div>    
    </nav>'
?>