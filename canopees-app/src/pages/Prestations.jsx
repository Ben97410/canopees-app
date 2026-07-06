import { useState, useEffect } from "react";

export default function Prestations() {
  const [activeModale, setActiveModale] = useState(null);
  const [dataApi, setDataApi] = useState([]);

  useEffect(() => {
    fetch('http://localhost:8000/api/prestations')
      .then((res) => res.json())
      .then((data) => {
        // API Platform utilise souvent 'hydra:member' pour les collections
        const result = data["hydra:member"] || data.member || [];
        setDataApi(result);
      })
      .catch((err) => {
        console.error("Erreur API:", err);
        setDataApi([]);
      });
  }, []);

  console.log("Données API reçues :", dataApi);

  return (
    <main className="page-prestations">
      
      {/* SECTION 1 : Bannière Orange 1 (Prestations 0 à 2) */}
      <section className="banniere-orange-1">
        {dataApi.slice(0, 3).map((item) => (
          <div key={item.id} className="bloc-membre">
            <div className="photo-prestations">
              <img 
                src={item.image ? `http://localhost:8000/uploads/prestations/${item.image}` : "/images/default.png"}
                alt={item.titre} 
              />
              <p>{item.titre}</p>
            </div>
            <button className="btn-selectionner" onClick={() => setActiveModale(item.id)}>
              Sélectionner
            </button>
          </div>
        ))}
      </section>

      <div className="separateur-prestations">
        <h2>Découvrez nos prestations</h2>
      </div>

      {/* SECTION 2 : Bannière Orange 2 (Prestations 3 à 5) */}
      <section className="banniere-orange-2">
        <div className="contenu-texte-bas">
          {dataApi.slice(3, 6).map((item) => (
            <div key={item.id} className="bloc-membre">
              <div className="photo-prestations">
                <img 
                  src={item.image ? `http://localhost:8000/uploads/prestations/${item.image}` : "/images/default.png"}
                  alt={item.titre} 
                />
                <p>{item.titre}</p>
              </div>
              <button className="btn-selectionner" onClick={() => setActiveModale(item.id)}>
                Sélectionner
              </button>
            </div>
          ))}
        </div>
      </section>

      {/* GESTION DES MODALES DYNAMIQUES */}
      {dataApi.map((modale) => (
        activeModale === modale.id && (
          <div 
            key={modale.id} 
            className="modale" 
            style={{ display: "block" }} 
            onClick={() => setActiveModale(null)}
          >
            <div className="contenu-modale" onClick={(e) => e.stopPropagation()}>
              <span className="fermer" onClick={() => setActiveModale(null)}>&times;</span>
              
              <h3>{modale.titre}</h3>
              
              <div dangerouslySetInnerHTML={{ __html: modale.contenuDetaille || "" }} />
              
              <div className="galerie-photos">
                {/* Utilisation de la relation corrigée : imagesModale */}
                {modale.imagesModale?.map((img, index) => (
                  <div key={index} className="item-galerie">
                    <img 
                      src={`http://localhost:8000/uploads/modales/${img.image}`} 
                      alt={img.legende || "Photo"} 
                    />
                    {img.legende && <p>{img.legende}</p>}
                  </div>
                ))}
              </div>
            </div>
          </div>
        )
      ))}
    </main>
  );
}