
if (window.innerWidth >= 320) {
     const images = [
        "../imgs/hokejbal-170T-1-700x400.jpg",
        "../imgs/o2arena1-700x400.jpg",
        "../imgs/sparta-kralovka-700x400.jpg"
    ];

    let currentImage = 0;

    const carouselImage = document.getElementById("carousel-img");

    setInterval(() => {
        currentImage = (currentImage + 1) % images.length;
        carouselImage.src = images[currentImage];
    }, 5000);
    
} else if (window.innerWidth < 320) {
    /*Sem stačí pridať odkazy na iné foto a už je to pripravené aby sa rotovali*/ 
    const images = [
    "../imgs/Pardubice1-1-286x163.jpg"
    ];

    let currentImage = 0;

    const carouselImage = document.getElementById("carousel-img");

    setInterval(() => {
        currentImage = (currentImage + 1) % images.length;
        carouselImage.src = images[currentImage];
    }, 5000);
}