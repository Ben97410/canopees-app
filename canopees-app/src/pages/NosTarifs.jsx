import { useState,useEffect } from "react";

export default function NosTarifs() {
  const [activeModale, setActiveModale] = useState(null);
  const [tarifs, setTarifs] = useState([]);



useEffect(() => {
    fetch('http://127.0.0.1:8000/api/tarifs')
      .then((response) => response.json())
      .then((data) => setTarifs(data['hydra:member'] || []))
      .catch((error) => console.error("Erreur lors du fetch des tarifs :", error));
  }, []);

const ouvrirModale = (id) => {
    setActiveModale(id);
    document.body.style.overflow = "hidden";
  };

  const fermerModale = () => {
    setActiveModale(null);
    document.body.style.overflow = "auto";
  };

  const modalesData = [
    { id: "modaleEntretien", title: "Sublimez votre jardin à prix dégressif avec nos forfaits annuels tout compris dès 300€ TTC ou nos interventions ponctuelles à partir de 2€/m² !", images: ["entretien espace vert tarifs1.jpg", "entretien espace vert tarif 2.jpg", "entretien espace vert tarif3.jpg", "entretien espace vert tarif4.jpg"] },
    { id: "modaleConception", title: "Optez pour une expertise sur mesure avec nos services de conception dès 350€ par 1 000 m² ou confiez-nous la création de votre jardin pour seulement 5€ à 8€ le m² !", images: ["conception tarif1.jpg", "conception tarif 2.jpg", "conception tarif 3.jpg", "conception tarif4.jpg"] },
    { id: "modaleTaille", title: "Sublimez vos extérieurs avec nos services de taille spécialisés, de l'entretien fruitier à la mise en forme de vos haies, pour un budget maîtrisé allant de 100 € à 680 € selon vos besoins !", images: ["taille haie tarif1.jpg", "taille haie tarif3.jpg", "taillehaie tarif2.jpg", "taille haie tarif4.jpg"] },
    { id: "modaleElagage", title: "Sécurisez et valorisez votre patrimoine arboré avec nos interventions d'élagage expertes, allant de 150 € pour vos arbustes jusqu'à 2 000 € pour vos sujets les plus majestueux, pour un entretien adapté à chaque hauteur !", images: ["elagages tarif1.jpg", "elagages tarif2.jpg", "elagages tarif3.jpg", "elagages tarif4.jpg"] },
    { id: "modaleAbattage", title: "Confiez-nous la mise en sécurité de votre terrain grâce à nos services d'abattage professionnel, avec des tarifs transparents allant de 130 € pour les petits sujets jusqu'à 650 € pour les arbres de 20 mètres !", images: ["abattages tarif1.jpg", "abattage tarif2.jpg", "abattages tarifs 3.jpg", "abattages tarif4.jpg"] },
    { id: "modaleDechets", title: "Optimisez la gestion de vos chantiers avec nos solutions de collecte sur mesure, du passage ponctuel à 300 € pour 15 m³ jusqu'au forfait sérénité spécial maison individuelle à partir de 1 500 € pour 6 passages !", images: ["composting 1 tarifs.jpg", "composting2tarifs.jpg", "composting3tarifs.jpg", "composting4tarifs.jpg"] }
  ];

  return (
    <main className="page-tarifs">
      <section className="banniere-orange-1">
        {[
          { id: "modaleEntretien", img: "entretien espace vert nos tarifs.jpg", label: "Entretiens espace verts", price: "300€" },
          { id: "modaleConception", img: "conception nos tarifs.jpg", label: "Conception", price: "350€" },
          { id: "modaleTaille", img: "taille haie nos tarifs.jpg", label: "Taille des haies", price: "100€" }
        ].map((item) => (
          <div key={item.id} className="bloc-membre">
            <div className="photo-prestations">
              <img src={`/images/${item.img}`} alt={item.label} />
              <p>{item.label}</p>
            </div>
            <button className="btn-selectionner" onClick={() => ouvrirModale(item.id)}>à partir de {item.price}</button>
          </div>
        ))}
      </section>

      <section className="banniere-orange-2">
        <div className="contenu-texte-bas">
          {[
            { id: "modaleElagage", img: "elagages nos tarifs.jpg", label: "Elagage", price: "150€" },
            { id: "modaleAbattage", img: "abbatages nos tarifs.jpg", label: "Abattage", price: "130€" },
            { id: "modaleDechets", img: "compostage nos tarifs.jpg", label: "Valorisation des déchets verts", price: "300€" }
          ].map((item) => (
            <div key={item.id} className="bloc-membre">
              <div className="photo-prestations">
                <img src={`/images/${item.img}`} alt={item.label} />
                <p>{item.label}</p>
              </div>
              <button className="btn-selectionner" onClick={() => ouvrirModale(item.id)}>à partir de {item.price}</button>
            </div>
          ))}
        </div>
      </section>

      {modalesData.map((modale) => (
        activeModale === modale.id && (
          <div key={modale.id} className="modale" style={{ display: "block" }} onClick={fermerModale}>
            <div className="contenu-modale" onClick={(e) => e.stopPropagation()}>
              <span className="fermer" onClick={fermerModale}>&times;</span>
              <h3>{modale.title}</h3>
              <div className="galerie-photos">
                {modale.images.map((img, index) => (
                  <img key={index} src={`/images/${img}`} alt="Chantier" />
                ))}
              </div>
            </div>
          </div>
        )
      ))}
    </main>
  );
}