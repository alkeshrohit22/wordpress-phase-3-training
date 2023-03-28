<?php
/*
Plugin Name:  Custom Popup plugin.
Description:  Popup image on home page load.
Version:      1.0.0
Author:       Alkesh Rohit
*/

//custom popup plugin function
function image_popup_idc(){
    if(is_front_page()){
        ?>
        <div class="image-popup">
            <div class="image-box">
                <a href = "#" target="_blank">
                    <img src = "http://localhost/wordpress-phase-3/wordpress-6.1.1/wordpress/wp-content/uploads/2023/03/popup-image.png"
                         alt = "" width="750px" height="400px">
                </a>
                <div class="space">
                    <div class="close-button">&times;</div>
                </div>
            </div>
        </div>

    <!--    script for the pop-up function -->
        <script>
            const loginPopup = document.querySelector(".image-popup");
            const close = document.querySelector(".close-button");
            window.addEventListener("load",function(){
                visiblePopup();
            })
            function visiblePopup(){
                const timeLimit = 1;
                let i=0;
                const timer = setInterval(function(){
                    i++;
                    if(i == timeLimit){
                        clearInterval(timer);
                        loginPopup.classList.add("visible");
                    }
                    console.log(i)
                },1000);
            }
            close.addEventListener("click",function(){
                loginPopup.classList.remove("visible");
            })
        </script>
	<?php
    }
}
add_action('wp_footer', 'image_popup_idc');