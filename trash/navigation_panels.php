
<section id="sidebar">
    <a href="#" class="brand">
        <span class="text"><img src="../../../../Assets/images/Brand Icons/the_application.in_logo_1.png"
                alt="theapplication.in logo" srcset="" style="width:70%;height:auto;padding-left:8%;padding-top:15%;">
        </span>
    </a>
    <ul class="side-menu top">

        <!-- <?php if ($Current_Release_Version != '1.2.3') { ?> -->
        <li>
            <button
                style="background-color:rgb(87, 155, 243); color:white; padding:5px 10px; border-radius:50px; margin-left:20%; border:none;">
                Update Available
            </button>
        </li>
        <?php } else { ?>
        <li>
            <button
                style="background-color:rgb(231, 231, 231); color:rgb(0, 0, 0); padding:5px 10px; border-radius:50px; margin-left:20%; border:none;">
                Installed Latest Version
            </button>
        </li>
        <?php } ?>


        <li <?php echo (basename(htmlspecialchars($_SERVER['PHP_SELF']))==='index.php' ) ? 'class="active"' : '' ; ?>>
            <a href="index.php">
                <i class='bx'><span class="material-symbols-outlined">dashboard</span></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li <?php echo (basename(htmlspecialchars($_SERVER['PHP_SELF']))==='HOI_Admission_Date.php' ) ? 'class="active"'
            : '' ; ?>>
            <a href="HOI_Admission_Date.php">
                <i class='bx'><span class="material-symbols-outlined">calendar_month</span></i>
                <span class="text">Dates</span>
            </a>
        </li>
        <li <?php echo (basename(htmlspecialchars($_SERVER['PHP_SELF']))==='HOI_Bank_Details.php' ) ? 'class="active"'
            : '' ; ?>>
            <a href="HOI_Bank_Details.php">
                <i class='bx'><span class="material-symbols-outlined">currency_rupee</span></i>
                <span class="text">Bank Acc.</span>
            </a>
        </li>
        <!-- <li <?php echo (basename(htmlspecialchars($_SERVER['PHP_SELF'])) === 'HOI_Important_Dates.php') ? 'class="active"' : ''; ?>>
            <a href="HOI_Important_Dates.php">
                <i class='bx'><span class="material-symbols-outlined">schedule</span></i>
                <span class="text">Imp. Dates</span>
            </a>
        </li> -->
        <li <?php echo (basename(htmlspecialchars($_SERVER['PHP_SELF']))==='HOI_Subject_Combo.php' ) ? 'class="active"'
            : '' ; ?>>
            <a href="HOI_Subject_Combo.php">
                <i class='bx'><span class="material-symbols-outlined">auto_stories</span></i>
                <span class="text">Subject Combo</span>
            </a>
        </li>
        <li <?php echo (basename(htmlspecialchars($_SERVER['PHP_SELF']))==='HOI_Admit_Students.php' ) ? 'class="active"'
            : '' ; ?>>
            <a href="HOI_Admit_Students.php">
                <!-- <i class='bx'><span class="material-symbols-outlined">info</span></i> -->
                <i class='bx'><span class="material-symbols-outlined">new_releases</span></i>
                <span class="text">Admit</span>
            </a>
        </li>
        <li <?php echo (basename(htmlspecialchars($_SERVER['PHP_SELF']))==='HOI_Final_List.php' ) ? 'class="active"'
            : '' ; ?>>
            <a href="HOI_Final_List.php">
                <i class='bx'><span class="material-symbols-outlined">delete_forever</span></i>
                <span class="text">Revoke</span>
            </a>
        </li>

        <li <?php echo (basename(htmlspecialchars($_SERVER['PHP_SELF']))==='HOI_Mail_to_Students.php' ||
            basename(htmlspecialchars($_SERVER['PHP_SELF']))==='HOI_Bunch_Mail_Sender.php' ) ? 'class="active"' : '' ;
            ?>>
            <a href="HOI_Mail_to_Students.php">
                <i class='bx'><span class="material-symbols-outlined">mail</span></i>
                <span class="text">Send Mail</span>
            </a>
        </li>
        <li <?php echo (basename(htmlspecialchars($_SERVER['PHP_SELF']))==='HOI_Admission_Merit_list.php' )
            ? 'class="active"' : '' ; ?>>
            <a href="HOI_Admission_Merit_list.php">
                <i class='bx'><span class="material-symbols-outlined">id_card</span></i>
                <span class="text">Merit List</span>
            </a>
        </li>




    </ul>
    <ul class="side-menu">
        <li <?php echo (basename(htmlspecialchars($_SERVER['PHP_SELF']))==='HOI_School_Preferences.php' )
            ? 'class="active"' : '' ; ?>>
            <a href="HOI_School_Preferences.php">
                <i class='bx'> <span class="material-symbols-outlined">settings</span> </i>
                <span class="text">School Preferences</span>
            </a>
        </li>
        <li>
            <a href="HOI_Logout.php" class="logout">
                <i class='bx'><span class="material-symbols-outlined">Logout</span></i>
                <span class="text">Logout</span>
            </a>
        </li>
        <li>
            <a href="../../../../about_us.php">
                <i class='bx'><span class="material-symbols-outlined">group</span></i>
                <span class="text">About Us</span>
            </a>
        </li>
    </ul>

</section>
<script src="script.js"></script>
