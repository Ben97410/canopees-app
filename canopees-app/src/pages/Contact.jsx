import { useState,useEffect } from "react";

export default function Contact() {
  const [status, setStatus] = useState('idle');
  const [prestations, setPrestations] = useState([]);

  
  useEffect(() => {
    fetch('http://127.0.0.1:8000/api/prestations')
      .then((res) => res.json())
      .then((data) => {
        
        setPrestations(data['hydra:member'] || []);
      })
      .catch((err) => console.error("Erreur chargement prestations:", err));
  }, []);

 
  const handleSubmit = async (e) => {
    e.preventDefault();
    setStatus('sending');

    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());

    
    const payload = {
      nom: data.nom,
      prenom: data.prenom,
      email: data.email,
      telephone: data.telephone,
      budget: data.budget,
      adresse: data.adresse,
      message: data.message,
      
      prestation: `/api/prestations/${data.prestation_id}`,
      
      client: "/api/clients/1" 
    };

    try {
      const response = await fetch('http://127.0.0.1:8000/api/demande_devis', {
        method: 'POST',
        headers: { 
          'Content-Type': 'application/ld+json',
          'Accept': 'application/ld+json' 
        },
        body: JSON.stringify(payload),
      });

      if (response.ok) {
        setStatus('success');
      } else {
        const errorData = await response.json();
        console.error("Détails erreur API:", errorData);
        alert("Erreur lors de l'envoi. Vérifiez les champs.");
        setStatus('idle');
      }
    } catch (error) {
      console.error("Erreur réseau:", error);
      setStatus('idle');
    }
  };

  
  return (
    <main className="page-contact">
      <section className="banniere-contact">
        <div className="formulaire-container">
          {status === 'success' ? (
            <div style={{ textAlign: "center", padding: "40px", color: "#692b85" }}>
              <h3>Merci !</h3>
              <p style={{ color: "#333" }}>Votre demande de devis a bien été prise en compte.</p>
              <div style={{ fontSize: "50px", margin: "20px 0" }}>✅</div>
              <button onClick={() => window.location.reload()} className="btn-envoyer">Retour</button>
            </div>
          ) : (
            <>
              <h2>Demande de devis gratuit</h2>
              <p>Remplissez ce formulaire pour une estimation précise de vos travaux</p>
              <form className="form-contact" onSubmit={handleSubmit}>
                <div className="groupe-input">
                  <input type="text" name="nom" placeholder="Nom" required />
                  <input type="text" name="prenom" placeholder="Prénom" required />
                </div>
                <div className="groupe-input">
                  <input type="email" name="email" placeholder="Votre Email" required />
                  <input type="tel" name="telephone" placeholder="Téléphone" required />
                </div>
                <input type="text" name="budget" placeholder="Budget estimé (ex: 500€)" />
                <input type="text" name="adresse" placeholder="Adresse des travaux (Ville, Code Postal)" required />
                <div className="label-date">
                  <label htmlFor="date-debut">Début souhaité des travaux :</label>
                  <input type="date" id="date-debut" name="debut_travaux" />
                </div>
                <textarea name="message" rows="5" placeholder="Description détaillée..." required></textarea>
                <button type="submit" className="btn-envoyer" disabled={status === 'sending'}>
                  {status === 'sending' ? "Envoi en cours..." : "Obtenir mon devis"}
                </button>
              </form>
            </>
          )}
        </div>
      </section>

      <div className="image-large-separateur carte-contact" onClick={() => ouvrirModale('modaleCarte')}>
        <img src="/images/google map contact.jpg" alt="carte google map" />
        <span className="texte-carte">Voir la carte</span>
      </div>

      <div id="modaleCarte" className="modale" onClick={(e) => e.target.classList.contains('modale') && fermerModale('modaleCarte')}>
        <div className="contenu-modale">
          <span className="fermer" onClick={() => fermerModale('modaleCarte')}>&times;</span>
          <img src="/images/google map contact.jpg" alt="Carte Google" style={{ width: '100%', height: 'auto', borderRadius: '10px' }} />
        </div>
      </div>
    </main>
  );
}