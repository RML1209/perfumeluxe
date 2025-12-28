
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <title>About Perfume</title>
  
    <!-- Swiper.js CDN for slider -->
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- CSS ya kufanya iwe nzuri zaidi + kuficha scrollbar -->
<style>
    .customers-scroll::-webkit-scrollbar { display:none; }
    
    .customer-img {
        width:70px; 
        height:70px; 
        border-radius:50%; 
        object-fit:cover; 
        border:4px solid #pink; 
        box-shadow:0 5px 15px rgba(233,30,99,0.3);
        flex-shrink:0;
        transition:transform 0.3s;
    }
    .customer-img:hover { transform:scale(1.15); }
</style>

    <style>
    
        .btn-order {
            background: #25d366;
            color: white;
        }
        .btn-order:hover { background: #1da851; }
        .btn-chat {
            background: #e91e63;
            color: white;
        }
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }
        
    .comment-box {
            width: 95%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 4px;
        }
        
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }
        
        
        .btn {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
    
        /* Popup/Modal Style - Nzuri sana */
        .product-modal {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.85);
            z-index: 9999;
            overflow-y: auto;
            animation: fadeIn 0.4s;
        }
        .modal-content {
            max-width: 500px;
            margin: 20px auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(255,105,180,0.3);
        }
        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 50px;
            color: white;
            cursor: pointer;
            z-index: 10000;
        }
        .product-header {
            padding: 0;
        }
     
        
        .product-info {
            padding: 20px;
            background: #fff;
        }
        .price {
            font-size: 24px;
            color: #e91e63;
            font-weight: bold;
            margin: 10px 0;
        }
        .rating {
            margin: 15px 0;
        }
        .stars {
            color: #ffd700;
            font-size: 24px;
        }
        .comments {
            margin-top: 20px;
        }
        
    a{text-decoration:none;}
/* Style for the overall comment section */
.comments {
    width: 100%;
    max-width: 400px; 
    margin: 20px 0;
    margin-bottom: 70px;
    
}

/* Container for the input field and the send button */
.comment-input-bar {
    display: flex; 
    align-items: center; 
    border: 2px solid #333; 
    border-radius: 50px; 
    padding: 5px; 
    background-color: white;
}

/* The actual text input field */
.comment-input-bar .comment-box {
    flex-grow: 1; 
    border: none; 
    outline: none; 
    padding: 10px 15px;
    font-size: 16px;
    background: transparent; 
}

/* The send button/icon */
.comment-input-bar .send-btn {
    background:pink; /* Pink background for the button/icon */
    color: white;
    border: none;
    border-radius: 50%; /* Makes the button perfectly round */
    width: 40px; /* Size of the circle */
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    font-size: 18px; 
}
    </style>  

<!-- Button ya About Product (unaweka hii chini ya kila perfume) -->

<!-- Modal/Popup -->



    
    <div class="modal-content">
        <!-- Slideshow ya Picha -->
        <div class="product-header">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="1762077477_1760719856_1760625054_perfume1.jpg" style="width:100%; height:400px; object-fit:cover;">
                    </div>
                    <div class="swiper-slide">
                        <img src="1762076922_perfume2.jpg" style="width:100%; height:400px; object-fit:cover;">
                    </div>
                    <div class="swiper-slide">
                        <img src="1761585515_1760640890_1760625282_perfume3.jpg" style="width:100%; height:400px; object-fit:cover;">
                    </div>
                </div>
                <!-- Navigation arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <!-- Maelezo ya Product -->
        <div class="product-info">
            <h2 style="margin-top:0; color:darkgreen;">Oud Imperial Luxe</h2>
            <div class="price">Tsh 250,000</div>
            
            <p>Harufu ya kifahari yenye mchanganyiko wa Oud asili, Vanilla na Rose. Inadumu zaidi ya masaa 12. Inafaa kwa hafla za kifahari na matumizi ya kila siku.</p>
            
            <div class="rating">
                <span class="stars">★★★★★</span> <strong>4.9</strong> (238 reviews)
                <!-- Ongeza hivi ndani ya <div class="product-info"> – baada ya maelezo ya kawaida -->

<!-- 1. Limited Stock Alert (Inawafanya waoge kununua sasa hivi) -->
<div style="background:#ffebee; padding:15px; border-radius:12px; border-left:5px solid #e91e63; margin:15px 0;">
    <strong>🚨 Haraka! Imebaki chupa chache leo!</strong><br>
    <small>Wateja 23 wameangalia bidhaa hii saa moja iliyopita</small>
</div>
<!-- 2. SOCIAL PROOF - HORIZONTAL SCROLLABLE (Mouse + Touch) -->
<div style="margin:30px 0;">


    <p style="font-weight:bold; color:#e91e63; text-align:center; margin-bottom:15px; font-size:18px;">
        Wateja Wetu Wanasema...
    </p>

    <!-- Scroll Container - Super Smooth -->
    <div class="customers-scroll" 
         style="overflow-x:auto; 
                scroll-behavior:smooth; 
                padding:15px 0; 
                scrollbar-width:none; 
                -ms-overflow-style:none;">
        
        <div style="display:flex; gap:18px; padding:0 10px;">
            
            <!-- Picha za wateja (unaweza kuongeza zaidi hapa) -->
            <img src="https://images.unsplash.com/photo-1524504388944-b5a2d8c51a41?w=400" class="customer-img">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400" class="customer-img">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400" class="customer-img">
            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400" class="customer-img">
            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=400" class="customer-img">
            <img src="https://images.unsplash.com/photo-1554151228-14d9def656e4?w=400" class="customer-img">
            <img src="https://images.unsplash.com/photo-1555952517-2a4f8c5f2d77?w=400" class="customer-img">
            <img src="https://images.unsplash.com/photo-1580489940927-36e65d18a2c8?w=400" class="customer-img">
            <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400" class="customer-img">
            
            <!-- +89 Badge -->
            <!--<div style="background:#e91e63; color:white; min-width:70px; height:70px; 
                        border-radius:50%; display:flex; align-items:center; justify-content:center; 
                        font-weight:bold; font-size:18px; box-shadow:0 5px 15px rgba(233,30,99,0.4);">--!>
               <!-- +89
            </div>--!>
        </div>
    </div>

    <small style="display:block; text-align:center; margin-top:10px; color:#666;">
        Zaidi ya wateja 89 wameridhia harufu hii
    </small>


<!-- 3. Discount Popup (Ina appear baada ya sekunde 15) -->
<div id="discountPopup" style="display:none; position:fixed; bottom:20px; left:50%; transform:translateX(-50%); background:pink; color:darkgreen; padding:10px 20px; border-radius:50px; box-shadow:0 10px 30px rgba(233,30,99,0.4); z-index:99999; animation: bounce 2s infinite;"><a href="#">
    🎁 Now view <strong>" MY PROFILE"</strong><br>          to get 10% offer!</a>
</div>

<!-- 4. Trust Badges (Zinaondoa hofu) -->
<div style="text-align:center; margin:20px 0;">
    <p style="font-size:14px; color:pink;">💎 Bidhaa Asili 100% | 🚚 Delivery Ndani ya Saa 24 | ✅ Kurudishiwa Pesa Ikiwa Hautaridhia</p>
</div>

<!-- 5. Scarcity Timer (Inaonyesha offer inaisha) -->
<!--<div style="background:#fff8e1; padding:15px; border-radius:12px; text-align:center; margin:15px 0;">
   <!-- <strong>⏰ Offer Inamalizika Baada Ya:</strong><br>
  --!><!--  <div style="font-size:24px; font-weight:bold; color:#e91e63;" id="countdown">02:15:47</div>--!>
   <!-- <small>Pata chupa ya pili kwa bei ya offer sasa!</small>
</div>--!>



<!-- 7. Video Testimonial (Inawapa uhakika zaidi) -->
<!--<div style="margin:20px 0;">
    <p style="font-weight:bold; color:#e91e63;">Angalia Mteja Anasema...</p>
    <iframe width="100%" height="200" src="https://www.youtube.com/embed/TU_BADILISHE_NA_LINK_YAKO" frameborder="0" allowfullscreen style="border-radius:12px;"></iframe>
    <small style="display:block; text-align:center; margin-top:5px;">Aisha from Dar es Salaam</small>
</div> --!>

                
            </div>

            <div class="action-buttons">
            
          <!-- ORDER BUTTON -->
<button class="btn btn-chat" style="background:red;" onclick="window.open('order.php', '_blank')">
    <i class="fas fa-shopping-cart"></i>
</button>  
       <!-- OFFER BUTTON -->
<button class="btn btn-chat" style="background:blue;" onclick="window.open('offer.php', '_blank')">
    <i class="fas fa-gift"></i>
</button>
<!-- WHATSAPP BUTTON -->
<button class="btn btn-chat" style="background:green;" onclick="window.open('https://wa.me/255XXXXXXXXX?text=Habari%2C%20nahitaji%20kujua%20zaidi%20kuhusu%20bidhaa', '_blank')">
    <i class="fab fa-whatsapp"></i>
</button>
<!-- PAYMENTS BUTTON -->
<button class="btn btn-chat" style="background:gray;" onclick="window.open('payments.php', '_blank')">
    <i class="fas fa-credit-card"></i>
</button>

<!-- FAVOURITES BUTTON -->
<button class="btn btn-chat" style="background:pink;" onclick="window.open('favourites.php', '_blank')">
    <i class="fas fa-heart"></i>
</button>


            </div>

        <div class="comments">
    <h3 style="margin-bottom: 10px;font-size:14px;font-family:sans-serif;">Wacha Maoni Yako</h3>
    
    <div class="comment-input-bar">
    <form action="save_comment.php" method="POST">

        <input type="text" name="comment" class="comment-box" placeholder="Comment now..." />
        
        <button class="send-btn" type="submit">
            <i class="fas fa-paper-plane"></i>
        </button>
        </form>
    </div>
</div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT YA DRAG SCROLL KWA MOUSE (Super Smooth) for docial proof-->
<script>
    const scrollContainer = document.querySelector(".customers-scroll");

    let isDown = false;
    let startX;
    let scrollLeft;

    scrollContainer.addEventListener("mousedown", (e) => {
        isDown = true;
        scrollContainer.style.cursor = "grabbing";
        startX = e.pageX - scrollContainer.offsetLeft;
        scrollLeft = scrollContainer.scrollLeft;
    });

    scrollContainer.addEventListener("mouseleave", () => {
        isDown = false;
        scrollContainer.style.cursor = "grab";
    });

    scrollContainer.addEventListener("mouseup", () => {
        isDown = false;
        scrollContainer.style.cursor = "grab";
    });

    scrollContainer.addEventListener("mousemove", (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - scrollContainer.offsetLeft;
        const walk = (x - startX) * 2; // Speed ya kuteleza
        scrollContainer.scrollLeft = scrollLeft - walk;
    });

    // Bonus: Cursor inabadilika iwe "grab"
    scrollContainer.style.cursor = "grab";
</script> 
<script>
    // Initialize Swiper
    const swiper = new Swiper('.swiper', {
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    function openModal() {
        document.getElementById("productModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("productModal").style.display = "none";
    }

    // Close when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById("productModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<script>
// 1. Discount popup inaappear baada ya sekunde 15
setTimeout(() => {
    document.getElementById("discountPopup").style.display = "block";
}, 15000);

// 2. Countdown timer (2 hours)
let time = 2 * 60 * 60; // 2 hours in seconds
setInterval(() => {
    if (time > 0) {
        time--;
        let h = Math.floor(time / 3600);
        let m = Math.floor((time % 3600) / 60);
        let s = time % 60;
        document.getElementById("countdown").innerHTML = 
            `${h.toString().padStart(2,"0")}:${m.toString().padStart(2,"0")}:${s.toString().padStart(2,"0")}`;
    }
}, 1000);

// Bounce animation
const style = document.createElement('style');
style.innerHTML = `
@keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50% { transform: translateX(-50%) translateY(-10px); }
}`;
document.head.appendChild(style);
</script>


</body>
</html>