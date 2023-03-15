  <!-- Sidebar source https://www.codinglabweb.com/2021/04/responsive-side-navigation-bar-in-html.html -->
  <div class="sidebar <?php echo $sidebar; ?>">
    <div class="logo-details" style="cursor: pointer;">
      <img src="<?=WEBSITE_URL;?>/assets/feedbot-logo.png" class="icon" style="height:28px; margin:8px;" onclick="window.location='<?= HOME_PAGE ?>'" title="<?=WEBSITE_NAME;?>"/>
        <div class="logo_name" onclick="window.location='<?= HOME_PAGE ?>'" title="<?=WEBSITE_NAME;?>"><?=WEBSITE_NAME;?></div>
        <?php if ($sidebar == 'open') { ?>
        <i class="fa fa-align-right" aria-hidden="true" id="btn"></i>
    <?php } elseif ($sidebar == 'close') { ?>
    	<i class="fa fa-bars" aria-hidden="true" id="btn"></i>
    <?php } else { ?>
    	<i class="fa fa-bars" aria-hidden="true" id="btn"></i>
    <?php } ?>
    </div>
    <ul class="nav-list">
     <?php if (!is_null($isconnected)) { ?>
      <li>
        <a href="<?= WEBSITE_URL ?>">
          <i class="fa fa-home" aria-hidden="true"></i>
          <span class="links_name"><?= HOME ?></span>
        </a>
         <span class="tooltip"><?= HOME ?></span>
      </li>
      <?php } ?>
     <li>
       <a href="<?= GLOBAL_PAGE ?>">
         <i class="fa fa-globe-w" aria-hidden="true"></i>
         <span class="links_name"><?= GLOBAL_FEED ?></span>
       </a>
       <span class="tooltip"><?= GLOBAL_FEED ?></span>
     </li>
     <?php if (!is_null($isconnected)) { ?>
    <li>
       <a href="<?= BOOKMARKS_PAGE ?>">
         <i class="fa fa-bookmark" aria-hidden="true"></i>
         <span class="links_name"><?= BOOKMARKS ?></span>
       </a>
       <span class="tooltip"><?= BOOKMARKS ?></span>
     </li>
      <li>
       <a href="<?= YOUR_FEEDS_PAGE ?>">
         <i class="fa fa-rss" aria-hidden="true"></i>
         <span class="links_name"><?= YOUR_SUBSCRIPTIONS ?></span>
       </a>
       <span class="tooltip"><?= YOUR_SUBSCRIPTIONS ?></span>
     </li>
      <li>
       <a href="<?= ADD_FEED_PAGE ?>">
         <i class="fa fa-plus-circle" aria-hidden="true"></i>
         <span class="links_name"><?= ADD_FEED ?></span>
       </a>
       <span class="tooltip"><?= ADD_FEED ?></span>
     </li>
     <li>
       <a href="<?= STATUSES_PAGE ?>">
         <i class="fa fa-history" aria-hidden="true"></i>
         <span class="links_name"><?= YOUR_SHARES ?></span>
       </a>
       <span class="tooltip"><?= YOUR_SHARES ?></span>
     </li>
     <li>
          <i class="fa fa-search bx bx-search" aria-hidden="true"></i>
          <form style="background-color:initial;" action="<?=WEBSITE_URL;?>/search" method="POST">
          <input type="text" placeholder="<?=SEARCH;?>…" name="search">
          </form>
          <span class="tooltip"><?=SEARCH;?></span>
      </li>

      <?php if ($theme == "light") { ?>
      <li style="position:fixed; bottom:65px;" class="dark_mode">
       <button style="height:initial; border:0px; text-transform: initial; font-weight: initial;" onclick="dark_mode()">
         <i class="fa fa-moon" aria-hidden="true"></i>
         <span class="links_name">Mode sombre</span>
       </button>
       <span class="tooltip" style="margin-top: 7px;">Mode sombre</span>
     </li>

     <li style="position:fixed; bottom:65px; display:none;" class="light_mode">
       <button style="height:initial; border:0px; text-transform: initial; font-weight: initial;" onclick="light_mode()">
         <i class="fa fa-sun-o" aria-hidden="true"></i>
         <span class="links_name">Mode clair</span>
       </button>
       <span class="tooltip" style="margin-top: 7px;">Mode clair</span>
     </li>
     <?php } ?>

     <?php if ($theme == "dark") { ?>
      <li style="position:fixed; bottom:65px; display:none;" class="dark_mode">
       <button style="height:initial; border:0px; text-transform: initial; font-weight: initial;" onclick="dark_mode()">
         <i class="fa fa-moon" aria-hidden="true"></i>
         <span class="links_name">Mode sombre</span>
       </button>
       <span class="tooltip" style="margin-top: 7px;">Mode sombre</span>
     </li>

     <li style="position:fixed; bottom:65px;" class="light_mode">
       <button style="height:initial; border:0px; text-transform: initial; font-weight: initial;" onclick="light_mode()">
         <i class="fa fa-sun-o" aria-hidden="true"></i>
         <span class="links_name">Mode clair</span>
       </button>
       <span class="tooltip" style="margin-top: 7px;">Mode clair</span>
     </li>
     <?php } ?>

     <li class="profile">
         <div class="profile-details">
          <div class="profilepicture" style="background-image: url(<?php echo $useravatar; ?>);" alt="<?php echo $aka; ?>" title="<?php echo $aka; ?>"><a href="<?= SETTINGS_PAGE ?>" style="color:#FFF; display:block; width:100%; height:100%;"><i class="fa fa-cog" aria-hidden="true" style="color:#FFF; font-size: 20px; text-shadow: 0px 0px 5px rgba(0,0,0,1); margin-left:-13px; margin-top:9px;"></i></a></div>
           <div class="name_job">
             <div class="name"><?php echo $displayname; ?></div>
             <div class="job"><?php echo $aka; ?></div>
           </div>
         </div>
         <i class="fa fa-sign-out" aria-hidden="true" id="log_out" onclick="location.href='<?=WEBSITE_URL;?>/includes/disconnect.php';" style="cursor: pointer;"></i>
     </li>

 	 <?php } else { ?>

    <?php if ($theme == "light") { ?>
      <li style="position:fixed; bottom:65px;" class="dark_mode">
       <button style="height:initial; border:0px; text-transform: initial; font-weight: initial;" onclick="dark_mode()">
         <i class="fa fa-moon" aria-hidden="true"></i>
         <span class="links_name"><?=DARK_MODE;?></span>
       </button>
       <span class="tooltip" style="margin-top: 7px;"><?=DARK_MODE;?></span>
     </li>

     <li style="position:fixed; bottom:65px; display:none;" class="light_mode">
       <button style="height:initial; border:0px; text-transform: initial; font-weight: initial;" onclick="light_mode()">
         <i class="fa fa-sun-o" aria-hidden="true"></i>
         <span class="links_name"><?=LIGHT_MODE;?></span>
       </button>
       <span class="tooltip" style="margin-top: 7px;"><?=LIGHT_MODE;?></span>
     </li>
     <?php } ?>

     <?php if ($theme == "dark") { ?>
      <li style="position:fixed; bottom:65px; display:none;" class="dark_mode">
       <button style="height:initial; border:0px; text-transform: initial; font-weight: initial;" onclick="dark_mode()">
         <i class="fa fa-moon" aria-hidden="true"></i>
         <span class="links_name">Mode sombre</span>
       </button>
       <span class="tooltip" style="margin-top: 7px;">Mode sombre</span>
     </li>

     <li style="position:fixed; bottom:65px;" class="light_mode">
       <button style="height:initial; border:0px; text-transform: initial; font-weight: initial;" onclick="light_mode()">
         <i class="fa fa-sun-o" aria-hidden="true"></i>
         <span class="links_name">Mode clair</span>
       </button>
       <span class="tooltip" style="margin-top: 7px;">Mode clair</span>
     </li>
     <?php } ?>

 	 <li class="profile">
         <div class="profile-details">
           <img src="<?=WEBSITE_URL;?>/assets/missing.png" alt="profileImg" onclick="location.href='<?= WEBSITE_URL ?>/?p=signin';" style="cursor: pointer;">
           <div class="name_job">
             <div class="name"><?= GUEST ?></div>
             <div class="job"></div>
           </div>
         </div>
         <i class="fa fa-sign-in" aria-hidden="true" id="log_in" onclick="location.href='<?= WEBSITE_URL ?>/?p=signin';" style="cursor: pointer;"></i>
     </li>

 <?php } ?>


    </ul>
  </div>

  <script>
  let sidebar = document.querySelector(".sidebar");
  let closeBtn = document.querySelector("#btn");
  let searchBtn = document.querySelector(".bx-search");

  closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange();//calling the function(optional)
  });

  searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
    sidebar.classList.toggle("open");
    menuBtnChange(); //calling the function(optional)
  });

  // following are the code to change sidebar button(optional)
  function menuBtnChange() {
   if(sidebar.classList.contains("open")){
     closeBtn.classList.replace("fa-bars", "fa-align-right");//replacing the iocns class
     document.cookie = "open=open; path=/; max-age=" + 30*24*60*60; 
   }else {
     closeBtn.classList.replace("fa-align-right","fa-bars");//replacing the iocns class
     document.cookie = "open=close; path=/; max-age=" + 30*24*60*60; 
   }
  }
  </script>