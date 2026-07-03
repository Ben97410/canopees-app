import { BrowserRouter as Router, Routes, Route, Link, useLocation } from "react-router-dom";
import "./sass/main.scss";

import Accueil from "./pages/Accueil";
import QuiSommesNous from "./pages/QuiSommesNous";
import Prestations from "./pages/Prestations";
import Tarifs from "./pages/NosTarifs";
import Contact from "./pages/Contact";


function BanniereDynamique() {
  const location = useLocation();

  const titres = {
    "/": "Accueil",
    "/qui-sommes-nous": "Qui sommes nous ?",
    "/prestations": "Nos prestations",
    "/tarifs": "Nos Tarifs",
    "/contact": "Contact"
  };

  return (
    <section className="banniere-verte">
      <h2 className="titre-accueil">{titres[location.pathname] || "Canopées"}</h2>
    </section>
  );
}

function App() {
  return (
    <Router>
      <BanniereDynamique />

      <header>
        <nav className="navbar">
          <Link to="/">Accueil</Link>
          <Link to="/qui-sommes-nous">Qui sommes nous ?</Link>
          <Link to="/prestations">Nos prestations</Link>
          <Link to="/tarifs">Nos Tarifs</Link>
          <Link to="/contact">Contact</Link>
        </nav>
      </header>

      <Routes>
        <Route path="/" element={<Accueil />} />
        <Route path="/qui-sommes-nous" element={<QuiSommesNous />} />
        <Route path="/prestations" element={<Prestations />} />
        <Route path="/tarifs" element={<Tarifs />} />
        <Route path="/contact" element={<Contact />} />
      </Routes>

      <footer>
        <div className="footer-container">
          <div className="footer-column">
            <img src="/images/logo-canopees.png" alt="Logo-canopees" className="footer-logo" />
            <p className="logo-subtitle">Création et entretien espace vert</p>
          </div>

          <div className="footer-column">
            <h3>Nos Services</h3>
            <ul>
              <li>Entretiens des espaces verts</li>
              <li>Tailles des haies</li>
              <li>Elagages et abattage des arbres</li>
              <li>Valorisations des déchets verts (Compostage)</li>
            </ul>
          </div>

          <div className="footer-column contact-section">
            <h3>Contact</h3>
            <div className="contact-item">
              <span className="icon-phone">&#9742;</span>
              <p>06-58-96-25-41</p>
            </div>
            <p>46 impasse des Fraisiers Bat B</p>
            <p>Canopées@elagage.com</p>
          </div>
        </div>

        <p className="copyright">© 2026 Canopées | Mentions légales</p>
      </footer>
    </Router>
  );
}

export default App;