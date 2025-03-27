import React, { useEffect } from "react";
import { createRoot } from "react-dom/client";
import { BrowserRouter as Router, Routes, Route, Link } from "react-router-dom";
import NuevoAlumno from "./components/NuevoAlumno";

// Importamos AdminLTE manualmente después de React
import "admin-lte/dist/js/adminlte.min.js";

const Menu = () => {
    return (
        <div className="container mt-4">
            <h3 className="text-center mb-4">Menú de Opciones</h3>
            <div className="row">
                <div className="col-12 col-md-6 mb-3">
                    <Link to="/nuevo-alumno" className="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                        <i className="fas fa-user-plus me-2"></i> Nuevo Alumno
                    </Link>
                </div>
                <div className="col-12 col-md-6 mb-3">
                    <button className="btn btn-success w-100 d-flex align-items-center justify-content-center">
                        <i className="fas fa-chalkboard-teacher me-2"></i>{" "}
                        Cursos
                    </button>
                </div>


                <div className="col-12 col-md-6 mb-3">
                    <button className="btn btn-warning w-100 d-flex align-items-center justify-content-center">
                        <i className="fas fa-user-tie me-2"></i> Nuevo Docente
                    </button>
                </div>

                <div className="col-12 col-md-6 mb-3">
                    <button className="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                        <i className="fas fa-book me-2"></i> Materias
                    </button>
                </div>
            </div>
        </div>
    );
};

const App = () => {
    useEffect(() => {
        // Esto asegura que AdminLTE se inicializa después de que React se monta
        window.dispatchEvent(new Event("load"));
    }, []);

    return (
        <Router basename="/EPA/public/home">
            <Routes>
                <Route path="/" element={<Menu />} />
                <Route path="/nuevo-alumno" element={<NuevoAlumno />} />
            </Routes>
        </Router>
    );
};

const rootElement = document.getElementById("react-root");
if (rootElement) {
    createRoot(rootElement).render(<App />);
}
