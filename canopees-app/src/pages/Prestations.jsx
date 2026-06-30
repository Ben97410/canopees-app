import { useState ,useEffect} from "react";

export default function Prestations() {
  const [activeModale, setActiveModale] = useState(null);
  const [dataApi, setDataApi] = useState([]);


/* Initialisation de l'api */

  useEffect(() => {
    fetch('http://localhost:8000/api/prestations')
      .then(res => res.json())
      .then(data => setDataApi(data))
      .catch(err => console.log("API en attente, le site fonctionne en dur."));
  }, []);


/* Modales */

const modalesData = [
    { id: "modaleEntretien", title: "Nos réalisations : Entretien", images: ["gazon tondu.jpg", "gazon distance.jpg", "arbre et gazon 2.jpg", "arbre et gazon.jpg"] },
    { id: "modaleConception", title: "Nos réalisations : Conception", images: ["conception modale 2 garden 2.jpg", "conception modale 2 garden.jpg", "conception modale 2.jpg", "conception modale 3 garden.jpg"] },
    { id: "modaleTaille", title: "Nos réalisations : Taille des haies", images: ["conception modale 3 garden.jpg", "dame qui coupe modale 3.jpg", "chantier terminer modale 3.jpg", "haie labyrinthe modale 3.jpg"] },
    { id: "modaleElagage", title: "Nos réalisations : Élagage", images: ["modale4 couper1.jpg", "modale4 couper 2.jpg", "modale4couper3.jpg", "modale4couper4.jpg"] },
    { id: "modaleAbattage", title: "Nos réalisations : Abattage", images: ["abattagelidake54.jpg", "abattagemodale51.jpg", "abattagemodale52.jpg", "abattagemodale53.jpg"] },
    { id: "modaleDechets", title: "Nos réalisations : Valorisation des déchets", images: ["modale6compostage.jpg", "modale6compostage2.jpg", "modale6compostage3.jpg", "modale6compostage4.jpg"] }
  ];


  return (
    <main className="page-prestations">
      <section className="banniere-orange-1">
        {[
          { id: "modaleEntretien", img: "Men 3.png", label: "Entretiens espace verts" },
          { id: "modaleConception", img: "Garden.png", label: "Conception" },
          { id: "modaleTaille", img: "Men4.png", label: "Taille des haies" }
        ].map((item) => (
          <div key={item.id} className="bloc-membre">
            <div className="photo-prestations">
              <img src={`/images/${item.img}`} alt={item.label} />
              <p>{item.label}</p>
            </div>
            <button className="btn-selectionner" onClick={() => setActiveModale(item.id)}>Sélectionner</button>
          </div>
        ))}
      </section>

      <div className="separateur-prestations">
        <h2>Découvrez nos prestations</h2>
      </div>

      <section className="banniere-orange-2">
        <div className="contenu-texte-bas">
          {[
            { id: "modaleElagage", img: "Arbre.png", label: "Elagage" },
            { id: "modaleAbattage", img: "tree3.png", label: "Abattage" },
            { id: "modaleDechets", img: "Compostage.png", label: "Valorisation des déchets verts" }
          ].map((item) => (
            <div key={item.id} className="bloc-membre">
              <div className="photo-prestations">
                <img src={`/images/${item.img}`} alt={item.label} />
                <p>{item.label}</p>
              </div>
              <button className="btn-selectionner" onClick={() => setActiveModale(item.id)}>Sélectionner</button>
            </div>
          ))}
        </div>
      </section>

      {modalesData.map((modale) => (
        activeModale === modale.id && (
          <div key={modale.id} className="modale" style={{ display: "block" }} onClick={() => setActiveModale(null)}>
            <div className="contenu-modale" onClick={(e) => e.stopPropagation()}>
              <span className="fermer" onClick={() => setActiveModale(null)}>&times;</span>
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