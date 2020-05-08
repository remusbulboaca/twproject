<?php include('includes/header.php')?>
<?php require_once('includes/functions/function.php') ?>
<style>
    .button {
        background: #ffffff;
    font-family: "proxima_nova_rgregular";
    font-size: 1em;
    padding: 1.3vh 5vw;
    border-radius: 50px;
    border: 0;
    color: #191919;
    text-align: center;
    transition: all 0.3s ease 0s;
}

.button:hover{
    letter-spacing: 3px;
    border-radius: 6px;
    border-color: #cecece !important;
    transition: all 0.3s ease 0s;
        }
</style>
<body>
    <header>
        <a href="home.php">COLR</a>
    </header>
    <div class="all">
        <h2>Organize, find and enjoy 
            your cap’s collection in a
            modern, relaxed and 
            dynamic way</h2>
    <div class="signup">
        <h1>sign <span>up</span></h1>
        <form method="post" action="">
        
            <input type="email" id="email" name="email" placeholder="Email" required><br><br>
            <input type="text" id="fname" name="fname" placeholder="First name" required><br><br>
            <input type="text" id="lname" name="lname" placeholder="Last name" required><br><br>
            <input type="text" id="username" name="username" placeholder="Username" required><br><br>
            <input type="password" id="password" name="password" placeholder="Password" required><br><br>
            <button class="button"> Create account</button>
            <p style="color:red"> <?php user_validation() ?> </p>
        </form>
    
    </div>
    
    </div>  
    

        
    
</body>
</html>