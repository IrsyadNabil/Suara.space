<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Loading Screen</title>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: url('backgroundsign.jpg') no-repeat center center fixed;
    background-size: cover;
    color: white;
    overflow-x: hidden;
}

#loading-screen {
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

#loading-screen h1 {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 35px;
}

/* CARD + BOX */
.box {
    background: rgba(255, 255, 255, 0.05);
    padding: 35px;
    width: 480px;
    border-radius: 25px;
    backdrop-filter: blur(10px);
}

/* DROP SHADOW supaya melayang */
.card-container {
    background: rgba(200, 200, 200, 0.12);
    border-radius: 25px;
    padding: 40px;

    box-shadow:
        0 20px 40px rgba(0, 0, 0, 0.35),
        0 10px 20px rgba(0, 0, 0, 0.25);
}


/* ITEM */
.item {
    margin-bottom: 36px;
    position: relative;
}

.item span {
    display: block;
    text-align: left;
    margin-bottom: 8px;
    font-size: 16px;
}

/* PROGRESS BAR */
.bar {
    width: 100%;
    height: 16px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50px;
    overflow: hidden;
}

.fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #a347ff, #ff2f9d);
    border-radius: 50px;
}

/* BUTTON */
.button-next {
    margin-top: 10px;
    padding: 14px 40px;
    border-radius: 40px;
    background: #dc11e7ff;
    color: white;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: 0.25s ease;

    opacity: 0;
    pointer-events: none;
}

.button-next:hover {
    background: #ff5cc2;
    box-shadow: 0 0 10px #ff5cc2, 0 0 20px #ff3e9c;
}
</style>

</head>
<body>

<div id="loading-screen">
    <h1>Personalizing your Focus<br>sounds...</h1>

    <!-- FIXED DI SINI -->
    <div class="box card-container">

        <div class="item">
            <span>Activities</span>
            <div class="bar"><div class="fill" data-delay="0"></div></div>
            <div class="check"></div>
        </div>

        <div class="item">
            <span>Neural Effect Level</span>
            <div class="bar"><div class="fill" data-delay="700"></div></div>
            <div class="check"></div>
        </div>

        <div class="item">
            <span>Music Complexity</span>
            <div class="bar"><div class="fill" data-delay="1400"></div></div>
            <div class="check"></div>
        </div>

        <div class="item">
            <span>Genre Preferences</span>
            <div class="bar"><div class="fill" data-delay="2100"></div></div>
            <div class="check"></div>
        </div>

        <button class="button-next" id="nextBtn"><strong>Explore the Music</strong></button>

    </div>
</div>

<script>
let finishedBars = 0;

document.querySelectorAll(".fill").forEach((bar) => {
    const delay = parseInt(bar.dataset.delay);

    setTimeout(() => {
        bar.style.transition = "width 1.2s ease";
        bar.style.width = "100%";

        setTimeout(() => {
            finishedBars++;

            if (finishedBars === 4) {
                const btn = document.getElementById("nextBtn");
                btn.style.opacity = "1";
                btn.style.pointerEvents = "auto";
            }

        }, 1200);
    }, delay);
});
</script>

</body>
</html>