<?php

include("baglanti.php"); //baglanti.php'yi bu sayfaya bağladım


$username_err=""; //kullanıcı adı için hatalar
$parola_err="";

if(isset($_POST["giris"])){

    //kullanıcı adı doğrulama
    if(empty($_POST["kullaniciadi"])){
        $username_err="Kullanıcı adı boş geçilemez.";
    }
    else{
        $username=$_POST["kullaniciadi"]; //hatalı bir giriş olmadıysa girilen kullanıcı adını username'e atayacak
    }

    //parola doğrulama
    if(empty($_POST["parola"])){
        $parola_err="Parola boş geçilemez.";
    }
    
    else{
        $parola=$_POST["parola"];
    }
   

    if(isset($username) && isset($parola)){//eğer kullanıcıadı ve parola girildiyse

        $secim ="SELECT * FROM kullanicilar where kullanici_adi = '$username' "; //girilen değer kullanicilar tablosunun kullanici_adi sütununda geçip geçmediğine bakıyorum
        $calistir=mysqli_query($baglanti, $secim); 

        $kayitsayisi = mysqli_num_rows($calistir); //calistir sorgusu kaç tane sonuç üretti ona bakıyorum
        //veritabanında kullaniciadi'ni uniqe sectiğim için ya 1 ya 0 olacak

        if($kayitsayisi>0){

          $ilgilikayit=mysqli_fetch_assoc($calistir); //mevcut elemanın tüm verilerine ulaştım
          $hashlisifre=$ilgilikayit["parola"]; //mevcut elemanın parolasına eriştim

          if(password_verify($parola, $hashlisifre)){

              session_start();//dolar ve parola doğru ise farklı bir alana yönlendireceğim
              $_SESSION["kullanici_adi"]=$ilgilikayit["kullanici_adi"];
              $_SESSION["email"]=$ilgilikayit["email"];
              header("location:profile.php");//giriş yapıldığında farklı bir sayfaya yönlendiriyorurm

          }
          else{
            echo '<div class="alert alert-danger" role="alert">
       Hatalı parola.
      </div>';
          }

        }
        else{
          echo '<div class="alert alert-danger" role="alert">
       Hatalı bir kullanıcı adı girdiniz.
      </div>';
        }



        
    mysqli_close($baglanti);
}
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Üye Giriş Sayfası</title>
  </head>
  <body>

  <div class="col-md-8 py-5 px-3 mx-auto">

      <header class="pb-3 mb-5 border-bottom">
        <h2>
          <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
          <svg width="45px" height="45px" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--noto" preserveAspectRatio="xMidYMid meet"><path d="M94.9 71.35c-8.08-7.63-21.82-13.99-30.91-18.2c-1.54-.71-2.93-1.35-4.11-1.92c-3.43-1.65-8.12-6.22-6.1-11.47c1.36-3.55 4.81-5.34 10.27-5.34c1.75 0 3.67.2 5.72.58c7.12 1.33 12.52 3.99 15.58 5.5c.38.19.82.21 1.22.07c.39-.15.72-.45.89-.84l7.01-15.81c.31-.69.07-1.51-.57-1.93c-4.94-3.28-17.27-8.15-30.97-8.15c-1.98 0-3.95.1-5.87.3c-10.92 1.12-21.86 4.03-27.92 17.64c-3.78 8.47-3.77 18.01.01 24.89c4.04 7.51 10.66 10.87 19.04 15.11l1.08.55c6.05 3.02 13.3 6.38 18.07 8.59c7.05 3.4 9.66 9.44 8.04 13.08c-2.61 5.87-8.38 7.16-18.36 4.33c-8.81-2.39-16.94-9.14-19.21-11.15c-.34-.3-.79-.44-1.25-.38c-.45.06-.85.32-1.1.69L24.6 104.14c-.41.63-.32 1.46.22 1.98c5.63 5.43 10.22 8.59 18.17 12.5c5.35 2.63 13.18 4.21 20.95 4.21c8.12 0 27.95-1.88 36.65-19.26c5.55-11.12 3.48-22.84-5.69-32.22z" fill="#40C0E7"></path></svg>
            <span>Stix - Üsküdar Üniversitesi</span>
          </a>
        </h2>
      </header>

      <h4 class="ml-3">Stix Öğrenci Giriş Sayfası</h4>
    
  <div class="container p-3">
      <div class="card p-3">

            <form action="login.php" method="POST">

            <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Kullanıcı Adı</label>
            <input type="text" class="form-control 
            
            <?php
            if(!empty($username_err)){
                echo "is-invalid";
            }
           ?>
            
            " id="exampleInputEmail1" name= "kullaniciadi">
            <div id="validationServer03Feedback" class="invalid-feedback">
           <?php
            echo $username_err;
           ?>
         </div>
        </div>    
        
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Parola</label>
            <input type="password" class="form-control 
            
            <?php
            if(!empty($parola_err)){
                echo "is-invalid";
            }
           ?>
            
            " id="exampleInputPassword1" name= "parola">
            <div id="validationServer03Feedback" class="invalid-feedback">
            <?php
            echo $parola_err;
           ?>
         </div>
        </div>
        
    
        <button type="submit" name="giris" class="btn btn-primary">Giriş Yap</button>
        </form>

      </div>

  </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>     