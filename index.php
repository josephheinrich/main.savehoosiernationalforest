<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";
    include 'include.php';
    include 'templates/email_block.php';
    if (!$_POST) {
        $display_block = <<<END_OF_BLOCK
            <form method="POST" id="subscribe_form" action="$_SERVER[PHP_SELF]">
                <h5>Join our Newsletter!</h5>
                <div class="input-group mb-3 container newsletter">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email address" aria-label="Email address" aria-describedby="button-addon2">
                    <button class="btn btn-secondary" type="submit" id="button-addon2" name="subscribe">Subscribe</button>
                    <label id="subscribe_success"></label>
                    <label id="subscribe_error"></label>
                </div>
            </form>
        END_OF_BLOCK;
    } else if (($_POST) && isset($_POST['subscribe'])) {
        if ($_POST['email'] == "") {
            header("Location: index.php");
            exit;
        }
        else {
            //connect to database
            doDB();
    
            //check that email is in list
            emailChecker($_POST['email']);
    
            //get number of results and do action
            if (mysqli_num_rows($check_res) < 1) {
            //free result
            mysqli_free_result($check_res);
    
            //add record
            $add_sql = "INSERT INTO subscribers (email)
            VALUES('".$safe_email."')";
            $add_res = mysqli_query($mysqli, $add_sql)
            or die(mysqli_error($mysqli));
            $display_block = "<div class='input-group mb-3 mt-5 container newsletter'><p class='newsletter-info'>Thanks for signing up!</p></div>";
    
            $mail = new PHPMailer();
    
            $mail->From     = "noreply@savehoosiernationalforest.com";
            $mail->FromName = "Save Hoosier National Forest";
            $mail->addAddress($_POST['email']);
            $mail->isHTML(true);
            $mail->Subject  = "Thanks for signing up to the SaveHNF newsletter!";
            $mail->Body     = $email_block;
    
            try {
                $mail->send();
        
            } catch (Exception $e) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
            //close connection to MySQL
            mysqli_close($mysqli);
            } else {
                //print failure message
                $display_block = "<div class='input-group mb-3 mt-5 container newsletter'><p class='newsletter-info'>You're already subscribed!</p></div>";
            }
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Save Hoosier National Forest</title>
    <meta property="og:title"
        content="Save Hoosier National Forest | Stop the Buffalo Springs proposal">
    <meta property="og:description"
        content="Help preserve Hoosier National Forest and stop the Buffalo Springs proposal.">
    <meta property="og:image" content="https://savehoosiernationalforest.com/assets/images/tree-background-2.webp" />
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://savehoosiernationalforest.com">
    <link rel="stylesheet" href="assets/css/main.css" />
    <script src="assets/js/main.js"></script>
    <link rel="icon" href="assets/images/tree2.webp">
    <script src="https://kit.fontawesome.com/beac13736e.js" crossorigin="anonymous"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZPK818DM68"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZPK818DM68');
</script>
    <link
      rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin="crossorigin"
    />
    <link
      rel="preload"
      as="style"
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&amp;display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&amp;display=swap"
      media="print"
      onload="this.media='all'"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <noscript>
      <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&amp;display=swap"
      />
    </noscript>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div class="container-fluid m-0 p-0">
      <div class="intro">
        <div class="navigation">

          <div class="navigation-content">
            <a href="#" style="text-decoration: none; color: inherit">
            <div class="logo-container">
              <img src="assets/images/tree2.webp" height="50px" />
            </div>

            <div class="page-header-container">
              Save<span class="HNF-text">HNF</span>
            </div>
          </div>
          </div>
          </a>

        <div class="intro-main">
        <div class="alert alert-warning text-center" role="alert"><b>Action alert!</b> Please see attached for information on submitting a comment to the draft environmental assessment -
            <a href="/assets/Save Hoosier National Forest Comment Priod Details.pdf" class="alert-link">Click me for more details.</a>.
        </div>
          <h1>Save Hoosier National Forest</h1>
          <h3>Help stop the Buffalo Springs proposal!</h3>
          
          <?php echo "$display_block"; ?>

        </div>
        <img
          class="background-image"
          src="assets/images/tree-background-2.webp"
        />
      </div>
      
      <div class="action-items container mt-5 mb-3">
        <div class="row g-3 mb-3">
            <div class="col-12 text-center">
                <h1 id="impacts" style="letter-spacing: 5px;">
                    Impacts
                </h2>
            </div>
        </div>
        <div class="row g-3">
          <div class="col-12 col-sm-4 action-item">
            <div class="d-flex align-items-center justify-content-center flex-column">
                <h2>
                    <i class="fas fa-tree fa-3x" style="color:#0B292D"></i>
                </h2>
                <h4>
                    Over 18,000 acres are going to be logged, clear cut, and destroyed by the National Forest Service.
                </h4>
            </div>
          </div>
          <div class="col-12 col-sm-4 action-item">
            <div class="d-flex align-items-center justify-content-center flex-column">
              <h2>
                <i class="fab fa-gripfire fa-3x" style="color: #9A251B"></i>
              </h2>
              <h4>
                Over 12,000 acres are slated for prescribed burns, destroying the ground cover.
              </h4>
            </div>
          </div>
          <div class="col-12 col-sm-4 action-item">
            <div class="d-flex align-items-center justify-content-center flex-column">
              <h2>
                <!-- <i class="fas fa-frog fa-3x" style="color: #1B394E"></i> -->
                <i class="fas fa-globe-americas fa-3x" style="color: #1B394E"></i>
              </h2>
              <h4>
                Deforestation and forest damage is the cause of around 10% of global warming.
              </h4>
            </div>
          </div>
        </div>
      </div>
      <div class="contact-info container px-3 mb-3 mt-5">
          <div class="row g-3 mb-3">
            <div class="col-12 text-center" >
                <h1 style="letter-spacing: 5px;">
                    We need your help!
                </h2>
            </div>
          </div>
          <div class="row g-3">
              <div class="col-12 mb-3">
                <div class="text-center">
                    <h5 style="color:rgb(130, 130, 130);">
                        To help conserve the future of Hoosier National Forest please contact the elected officials below to voice your opinion.
                    </h5>
                </div>
              </div>
              <div class="col-12 col-lg-4 col-xxl-3 contact-item">
                  <div>
                    <h5>
                        Chris Thornton
                    </h5>
                    <p class="contact-description">
                        District Ranger, Tell City Ranger District
                    </p>
                    <p class="contact-info-heading">
                        Email
                    </p>
                    <p>
                        <b><a href="mailto:christopher.thornton@usda.gov">christopher.thornton@usda.gov</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Phone
                    </p>
                    <p style="margin-bottom: 0.2rem;">
                        <b><a href="tel:812-547-7051">812-547-7051</a></b>
                    </p>
                    <p style="margin-top:0.2rem;">
                        <b><a href="tel:812-547-9235">812-547-9235</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Mailing Address
                    </p>
                    <p>
                        <b>248 15th Street<br>Tell City, IN 47586</b>
                    </p>
                </div>
              </div>
              <div class="col-12 col-lg-4 col-xxl-3 contact-item">
                <div>
                    <h5>
                        Mike Chaveas
                    </h5>
                    <p class="contact-description">
                        Forest Supervisor, Hoosier National Forest
                    </p>
                    <p class="contact-info-heading">
                        Email
                    </p>
                    <p>
                        <b><a href="mailto:mike.chaveas@usda.gov">mike.chaveas@usda.gov</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Phone
                    </p>
                    <p>
                        <b><a href="tel:812-547-7051">812-275-5987</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Mailing Address
                    </p>
                    <p>
                        <b>811 Constitution Avenue<br>Bedford, IN 47421</b>
                    </p>
                </div>
              </div>
              <div class="col-12 col-lg-4 col-xxl-3 contact-item">
                <div>
                    <h5>
                        Gina Owens
                    </h5>
                    <p class="contact-description">
                        Regional Forester, Eastern Region
                    </p>
                    <p class="contact-info-heading">
                        Email
                    </p>
                    <p>
                        <b><a href="mailto:gina.owens@usda.gov">gina.owens@usda.gov</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Phone
                    </p>
                    <p>
                        <b><a href="tel:414-297-3600">414-297-3600</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Mailing Address
                    </p>
                    <p>
                        <b>626 East Wisconsin Ave<br>Milwaukee, WI 53202</b>
                    </p>
                </div>
              </div>
              <div class="col-12 col-lg-4 col-xxl-3 contact-item">
                <div>
                    <h5>
                        Randy Moore
                    </h5>
                    <p class="contact-description">
                        Forest Service Chief, USDA Forest Service
                    </p>
                    <p class="contact-info-heading">
                        Email
                    </p>
                    <p>
                        <b><a href="mailto:randy.moore@usda.gov">randy.moore@usda.gov</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Mailing Address
                    </p>
                    <p>
                        <b>1400 Independence Ave SW<br>Mailstop #1121<br>Washington, DC 20250</b>
                    </p>
                </div>
              </div>
              <!--Mike Braun-->
              <div class="col-12 col-lg-4 col-xxl-3 contact-item">
                <div>
                    <h5>
                        Mike Braun
                    </h5>
                    <p class="contact-description">
                        United States Senator
                    </p>
                    <p class="contact-info-heading">
                        Email
                    </p>
                    <p>
                        <b><a href="mailto:adam.battalio@braun.senate.gov">adam.battalio@braun.senate.gov</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Phone
                    </p>
                    <p>
                        <b><a href="tel:317-822-8240">317-822-8240</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Mailing Address
                    </p>
                    <p style="margin-bottom: 0.2rem;">
                        <b>115 N. Pennsylvania Street.<br>Indianapolis, IN 46204.</b>
                    </p>
                    <p style="margin-top: 0.2rem;">
                        <b>374 Russell Senate Office Building<br>Washington DC 20510</b>
                    </p>
                </div>
              </div>
              <!--Todd Young-->
              <div class="col-12 col-lg-4 col-xxl-3 contact-item">
                <div>
                    <h5>
                        Todd Young
                    </h5>
                    <p class="contact-description">
                        United States Senator
                    </p>
                    <p class="contact-info-heading">
                        Email
                    </p>
                    <p>
                        <b><a href="mailto:nancy_martinez@young.senate.gov">nancy_martinez@young.senate.gov</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Phone
                    </p>
                    <p>
                        <b><a href="tel:812-542-4820">812-542-4820</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Mailing Address
                    </p>
                    <p>
                        <b>3602 Northgate Court - Suite 15<br>New Albany, IN 47150</b>
                    </p>
                </div>
              </div>
              <!--Trey Hollingsworth-->
              <div class="col-12 col-lg-4 col-xxl-3 contact-item">
                <div>
                    <h5>
                        Trey Hollingsworth
                    </h5>
                    <p class="contact-description">
                        Congressman
                    </p>
                    <p class="contact-info-heading">
                        Email
                    </p>
                    <p>
                        <b><a href="mailto:kristen.sonderegger@mail.house.gov">kristen.sonderegger@mail.house.gov</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Phone
                    </p>
                    <p>
                        <b><a href="tel:317-851-8710">317-851-8710</a></b>
                    </p>
                    
                    <p class="contact-info-heading">
                        Mailing Address
                    </p>
                    <p style="margin-bottom: 0.2rem;">
                        <b>321 Quartermaster Court<br>Jeffersonville, IN 47130</b>
                    </p>
                    <p style="margin-top: 0.2rem;">
                        <b>1641 Longworth House Office Building<br>Washington, D.C. 20515</b>
                    </p>
                </div>
              </div>
              <!---->
              <div class="col-12 col-lg-4 col-xxl-3 contact-item">
                <div>
                    <h5>
                        Larry Bucshon
                    </h5>
                    <p class="contact-description">
                        Congressman
                    </p>
                    <p class="contact-info-heading">
                        Email
                    </p>
                    <p>
                        <b><a href="mailto:Conner.roberts@mail.house.gov">Conner.roberts@mail.house.gov</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Phone
                    </p>
                    <p>
                        <b><a href="tel:202-225-4636">202-225-4636</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Mailing Address
                    </p>
                    <p style="margin-bottom: 0.2rem;">
                        <b>First Floor, Small Conference Room<br>Jasper, IN 47547</b>
                    </p>
                    <p style="margin-top: 0.2rem;">
                        <b>2313 Rayburn House Office Building<br>Washington, DC 20515</b>
                    </p>
                </div>
              </div>
              <!--Kevin Amick-->
              <div class="col-12 col-lg-4 col-xxl-3 contact-item">
                <div>
                    <h5>
                        Kevin Amick
                    </h5>
                    <p class="contact-description">
                        Environmental Coordinator, Forest Service
                    </p>
                    <p class="contact-info-heading">
                        Email
                    </p>
                    <p>
                        <b><a href="mailto:kevin.amick@usda.gov">kevin.amick@usda.gov</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Phone
                    </p>
                    <p style="margin-bottom: 0.2rem;">
                        <b><a href="tel:202-225-4636">812-276-4746</a></b>
                    </p>
                    <p style="margin-top: 0.2rem"> 
                        <b><a href="tel:202-225-4636">812-276-4746</a></b>
                    </p>

                    <p class="contact-info-heading">
                        Mailing Address
                    </p>
                    <p style="margin-bottom: 0.2rem;">
                        <b>811 Constitution Ave<br>Bedford, IN 47421</b>
                    </p>
                </div>
              </div>
          </div>
      </div>
      <!--Upcoming Events-->
      <!-- <div class="container px-3 mt-5">
          <div class="row gy-3">
              <div class="col-12 text-center mb-3">
                  <h1 style="letter-spacing: 5px;">Upcoming Events</h1>
              </div>

              
            <div class="col-12 event-item">
                <div>
                  <div class="d-flex justify-content-between">
                      <p style="margin-bottom: 0px; color: rgb(198, 54, 54);">
                        Tuesday, April 26, from 6:00 to 8:00 PM EST
                      </p>
                      <p>
                          <a href="https://www.fs.usda.gov/detail/hoosier/?cid=FSEPRD872762" target="_blank">
                              <i class="fas fa-external-link-alt"></i>
                          </a>
                      </p>
                  </div>
                  <h3 style="margin-bottom:0.3rem;">
                    Virtual Public Meeting
                  </h3>
                  <p style="margin-top: 0px; color: rgb(140, 140, 140);">
                    <a href="https://teams.microsoft.com/dl/launcher/launcher.html?url=%2F_%23%2Fl%2Fmeetup-join%2F19%3Ameeting_OGJiZDhiODEtNjM4NC00NjYzLWJlM2EtMTEzNGU3NGU5ZmU3%40thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%3A%2522ed5b36e7-01ee-4ebc-867e-e03cfa0d4697%2522%252c%2522Oid%2522%3A%25227dd11776-c329-4c6b-bc7c-4e425af88870%2522%252c%2522IsBroadcastMeeting%2522%3Atrue%257d%26btype%3Da%26role%3Da%26anon%3Dtrue&type=meetup-join&deeplinkId=855900b6-ddd7-41a0-b34e-67c752409251&directDl=true&msLaunch=true&enableMobilePage=true&suppressPrompt=true" target="_blank">Microsoft Teams Meeting</a>
                  </p>
                  <p>
                    <a href="https://teams.microsoft.com/dl/launcher/launcher.html?url=%2F_%23%2Fl%2Fmeetup-join%2F19%3Ameeting_OGJiZDhiODEtNjM4NC00NjYzLWJlM2EtMTEzNGU3NGU5ZmU3%40thread.v2%2F0%3Fcontext%3D%257b%2522Tid%2522%3A%2522ed5b36e7-01ee-4ebc-867e-e03cfa0d4697%2522%252c%2522Oid%2522%3A%25227dd11776-c329-4c6b-bc7c-4e425af88870%2522%252c%2522IsBroadcastMeeting%2522%3Atrue%257d%26btype%3Da%26role%3Da%26anon%3Dtrue&type=meetup-join&deeplinkId=855900b6-ddd7-41a0-b34e-67c752409251&directDl=true&msLaunch=true&enableMobilePage=true&suppressPrompt=true" target="_blank">Join for an informational meeting</a> about the Buffalo Springs Restoration Project. The District Ranger will give a brief overview of the project, its current status and how the public may participate in the decision-making process. Several resource specialists will give brief presentations. The remainder of the time will be to address participant's questions.
                  </p>
                  <p>
                    To submit a question in advance, email <a href="mailto:r9_hoosier_website@fs.fed.us">r9_hoosier_website@fs.fed.us</a>
                  </p>
              </div>  
            </div>
        </div>
    </div> -->
    <!--Resources-->
    <div class="container px-3 mt-5">
          <div class="row gy-3">
              <div class="col-12 text-center mb-3">
                  <h1 style="letter-spacing: 5px;">Resources</h1>
              </div>

              <!--Event Item-->
            <div class="col-12 event-item">
                <div>
                  
                  <h3 style="margin-bottom:0.3rem;">
                    Google Drive Resource Bank
                  </h3>
                  <p style="margin-top: 0px; color: rgb(140, 140, 140);">
                    <a href="https://drive.google.com/drive/folders/16JlSuAMkdwAFEQW4Yiyu6yziexbqetLN?usp=sharing" target="_blank">SaveHNF Resources</a>
                  </p>
                  <p>
                    Check out the <a href="https://drive.google.com/drive/folders/16JlSuAMkdwAFEQW4Yiyu6yziexbqetLN?usp=sharing" target="_blank">SaveHNF public Google Drive</a> to view documents from the National Forest Service, press releases, past newsletters, and general information about the Buffalo Springs Restoration Project.
                 </p>
              </div>  
            </div>
        </div>
    </div><!--END Resources-->
      </div>
      <!-- <div class="bottom-image m-0 p-0">
      </div> -->
      <div class="footer d-flex justify-content-center align-items-center" style="height: 150px">
          <div class="row text-center mx-0">
            <div class="col-12 text-end">
                <p class="mx-sm-3" style="font-size: 40px">
                    <a href="https://www.facebook.com/groups/296704458944200" target="_blank"><i class="fab fa-facebook"></i></a>
                </p>
            </div>
          </div>
      </div>
    </div>
    <?php include "check_captcha.php"; ?>
  </body>
</html>
