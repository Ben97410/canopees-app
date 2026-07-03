import "../sass/main.scss";
import { useEffect,useState } from "react";
import $ from "jquery";

export default function Accueil() {
  const [oeuvres, setOeuvres] = useState([]);
  const [loading, setLoading] = useState(true);
  

useEffect(() => {
    fetch('http://localhost:8000/api/oeuvres')
      .then((response) => response.json())
      .then((data) => {
        const items = data.member || []; 
        console.log("Données trouvées :", items);
        setOeuvres(items);
        setLoading(false);
      })
      .catch((error) => console.error("Erreur API :", error));
  }, []);



useEffect(() => {
    if (loading) return; 

    const $carousel = $(".carousel");
    const $gardenRail = $(".carousel-garden");

    
    $carousel.empty();
    $gardenRail.empty();

    oeuvres.forEach(o => {
      // On construit l'URL complète vers le serveur back-end (Symfony)
     const imageUrl = `http://localhost:8000/uploads/oeuvres/${o.image}`;

      if (o.numCarrousel === 1) {
        $carousel.append(`<div class="carousel-slide"><img src="${imageUrl}" alt="${o.titre}" /></div>`);
      } else if (o.numCarrousel === 2) {
        $gardenRail.append(`<div class="carousel-slide-garden"><img src="${imageUrl}" alt="${o.titre}" /></div>`);
      }
    });
    

  }, [oeuvres, loading]); 



useEffect(() => {

    
    const $carousel = $(".carousel");
    if ($carousel.length > 0) {
      let currentIndex = 0;
      const $slides = $(".carousel-slide");
      const totalSlides = $slides.length;

      function showSlide(index) {
        if (index < 0) currentIndex = totalSlides - 1;
        else if (index >= totalSlides) currentIndex = 0;
        else currentIndex = index;

        const slideWidth = $slides.first().outerWidth() || 0;
        const gap = parseInt($carousel.css("gap")) || 0;
        $carousel.css("transform", `translateX(-${currentIndex * (slideWidth + gap)}px)`);
      }

      $("#nextButton").on("click", () => showSlide(currentIndex + 1));
      $("#prevButton").on("click", () => showSlide(currentIndex - 1));
    }

    // Gestion du carrousel des jardins


    const $gardenRail = $(".carousel-garden");
    if ($gardenRail.length > 0) {
      let gardenIndex = 0;
      const $gardenSlides = $(".carousel-slide-garden");

      function moveGarden(index) {
        if (index < 0) gardenIndex = $gardenSlides.length - 1;
        else if (index >= $gardenSlides.length) gardenIndex = 0;
        else gardenIndex = index;

        $gardenRail.css("transform", `translateX(-${gardenIndex * 264}px)`);
      }

      $("#nextGarden").on("click", () => moveGarden(gardenIndex + 1));
      $("#prevGarden").on("click", () => moveGarden(gardenIndex - 1));
    }



    return () => {
      $("#nextButton, #prevButton, #nextGarden, #prevGarden").off();
    };
  }, [oeuvres]);

  return (
    <main>
      <div className="nom-entreprise-accueil">
        <h1>Canopées</h1>
       <section className="hero">
          <button id="prevButton" className="btn-worker">❮</button>
          <div className="carousel-container">
            <div className="carousel"></div>     
          </div>
          <button id="nextButton" className="btn-worker">❯</button>
        </section>

        <section className="presentation">
          <p>
            La société Canopées a été créée en 2020 par Bob et Tom, deux grands passionnés de la nature.<br /><br />
            Notre société est spécialisée dans la création et l’entretien d’espaces verts pour les particuliers, les professionnels et les collectivités territoriales.<br /><br />
            Nos principales activités sont la conception et la réalisation d’espaces verts, l’entretien des espaces verts, la taille des haies, l’élagage et l’abattage des arbres, ainsi que la valorisation des déchets verts (compostage).<br /><br />
            Nous sommes ravis de proposer nos services et restons à votre disposition pour tout type de questions.
          </p>
        </section>

        <section className="banniere-orange-images-garden">
          <button id="prevGarden" className="btn-garden">❮</button>
          <div className="garden-container">
            <div className="carousel-garden" id="garden-carousel"></div>   
          </div>
          <button id="nextGarden" className="btn-garden">❯</button>
        </section>
      </div>
    </main>
  );
}