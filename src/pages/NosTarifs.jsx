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

  return (
    <main className="page-tarifs">
      
      {/* SECTION 1 : Les 3 premiers tarifs */}
      <section className="banniere-orange-1">
        {tarifs.slice(0, 3).map((tarif) => (
          <div key={tarif.id} className="bloc-membre">
            <div className="photo-prestations">
              {tarif.image ? (
                <img 
                  src={`http://127.0.0.1:8000/uploads/tarifs/${tarif.image}`} 
                  alt={tarif.titreBloc} 
                />
              ) : (
                <div className="image-placeholder">Image manquante</div>
              )}
              <p>{tarif.titreBloc}</p>
            </div>
            <button className="btn-selectionner" onClick={() => ouvrirModale(tarif.id)}>
              {tarif.prix ? `à partir de ${tarif.prix}` : "Voir les détails"}
            </button>
          </div>
        ))}
      </section>

      {/* SECTION 2 : Les tarifs suivants */}
      <section className="banniere-orange-2">
        <div className="contenu-texte-bas">
          {tarifs.slice(3).map((tarif) => (
            <div key={tarif.id} className="bloc-membre">
              <div className="photo-prestations">
                {tarif.image ? (
                  <img 
                    src={`http://127.0.0.1:8000/uploads/tarifs/${tarif.image}`} 
                    alt={tarif.titreBloc} 
                  />
                ) : (
                  <div className="image-placeholder">Image manquante</div>
                )}
                <p>{tarif.titreBloc}</p>
              </div>
              <button className="btn-selectionner" onClick={() => ouvrirModale(tarif.id)}>
                {tarif.prix ? `à partir de ${tarif.prix}` : "Voir les détails"}
              </button>
            </div>
          ))}
        </div>
      </section>

      {/* MODALES DYNAMIQUES */}
      {tarifs.map((tarif) => (
        activeModale === tarif.id && (
          <div key={tarif.id} className="modale" style={{ display: "block" }} onClick={fermerModale}>
            <div className="contenu-modale" onClick={(e) => e.stopPropagation()}>
              <span className="fermer" onClick={fermerModale}>&times;</span>
              
              <h3>{tarif.titreBloc}</h3>
              
              <div dangerouslySetInnerHTML={{ __html: tarif.texteTarifs }} />
              
              <div className="galerie-photos">
                {tarif.imagesGalerie && tarif.imagesGalerie.length > 0 ? (
                  tarif.imagesGalerie.map((imgObj) => (
                    <img 
                      key={imgObj.id} 
                      src={`http://127.0.0.1:8000/uploads/galerie/${imgObj.image}`} 
                      alt="Chantier" 
                    />
                  ))
                ) : (
                  <p>Aucune photo disponible pour ce tarif.</p>
                )}
              </div>
            </div>
          </div>
        )
      ))}
    </main>
  );
}