import { useState, useEffect } from "react";

export default function NosTarifs() {
  const [activeModale, setActiveModale] = useState(null);
  const [tarifs, setTarifs] = useState([]);

  useEffect(() => {
    fetch('http://127.0.0.1:8000/api/tarifs')
      .then((response) => response.json())
      .then((data) => {
        setTarifs(data.member || data['hydra:member'] || []);
      })
      .catch((error) => console.error("Erreur fetch :", error));
  }, []);

  const ouvrirModale = (id) => {
    fetch(`http://127.0.0.1:8000/api/tarifs/${id}`)
      .then((response) => response.json())
      .then((data) => {
        setActiveModale(data);
        document.body.style.overflow = "hidden";
      })
      .catch((error) => console.error("Erreur détail :", error));
  };

  const fermerModale = () => {
    setActiveModale(null);
    document.body.style.overflow = "auto";
  };

  return (
    <main className="page-tarifs">
      
      {/* SECTION 1 : Les 3 premiers tarifs */}
      <section className="banniere-orange-1">
        {tarifs.slice(0, 3).map((tarif) => (
          <div key={tarif.id} className="bloc-membre">
            <div className="photo-prestations">
              <img src={`http://127.0.0.1:8000/uploads/tarifs/${tarif.image}`} alt={tarif.titreBloc} loading="lazy" />
              <p>{tarif.titreBloc}</p>
            </div>
            <button className="btn-selectionner" onClick={() => ouvrirModale(tarif.id)}>
              {tarif.prix ? `à partir de ${tarif.prix}` : "Voir les détails"}
            </button>
          </div>
        ))}
      </section>

      {/* SECTION 2 : Les tarifs suivants  */}
      <section className="banniere-orange-2">
        <div className="contenu-texte-bas">
          {tarifs.slice(3).map((tarif) => (
            <div key={tarif.id} className="bloc-membre">
              <div className="photo-prestations">
                <img src={`http://127.0.0.1:8000/uploads/tarifs/${tarif.image}`} alt={tarif.titreBloc} loading="lazy" />
                <p>{tarif.titreBloc}</p>
              </div>
              <button className="btn-selectionner" onClick={() => ouvrirModale(tarif.id)}>
                {tarif.prix ? `à partir de ${tarif.prix}` : "Voir les détails"}
              </button>
            </div>
          ))}
        </div>
      </section>

      {/* MODALE DYNAMIQUE */}
      {activeModale && (
        <div className="modale" style={{ display: "block" }} onClick={fermerModale}>
          <div className="contenu-modale" onClick={(e) => e.stopPropagation()}>
            <span className="fermer" onClick={fermerModale}>&times;</span>
            
            <h3>{activeModale.titreBloc}</h3>
            <div className="description-modale" dangerouslySetInnerHTML={{ __html: activeModale.texteTarifs }} />
            
            <div className="galerie-photos">
              {activeModale.imagesGalerie?.length > 0 ? (
                activeModale.imagesGalerie.map((imgObj) => (
                  <img key={imgObj.id} src={`http://127.0.0.1:8000/uploads/galerie/${imgObj.image}`} alt="Chantier" loading="lazy" />
                ))
              ) : (
                <p>Aucune photo disponible.</p>
              )}
            </div>
          </div>
        </div>
      )}
    </main>
  );
}