import React, { useState } from "react";
import { useNavigate } from "react-router-dom";

const NuevoAlumno = () => {
    const navigate = useNavigate();
    const [alumno, setAlumno] = useState({
        nombre: "",
        apellido: "",
        dni: "",
        cuil: "",
        fecha_nacimiento: "",
        curso_division: "",
        email: ""
    });

    const handleChange = (e) => {
        setAlumno({
            ...alumno,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
    
        try {
            const response = await fetch(`${window.location.origin}/alumnos`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(alumno),
            });
    
            if (response.ok) {
                alert("Alumno registrado con éxito");
                navigate("/home");
            } else {
                const errorData = await response.json();
                alert("Error: " + (errorData?.errors ? JSON.stringify(errorData.errors) : "Error al registrar alumno"));
            }
        } catch (error) {
            console.error("Error al guardar el alumno:", error);
        }
    };
    
    

    return (
        <div className="container mt-4">
            <h2>Registrar Nuevo Alumno</h2>
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label className="form-label">Nombre</label>
                    <input
                        type="text"
                        className="form-control"
                        name="nombre"
                        value={alumno.nombre}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="mb-3">
                    <label className="form-label">Apellido</label>
                    <input
                        type="text"
                        className="form-control"
                        name="apellido"
                        value={alumno.apellido}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="mb-3">
                    <label className="form-label">DNI</label>
                    <input
                        type="text"
                        className="form-control"
                        name="dni"
                        value={alumno.dni}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="mb-3">
                    <label className="form-label">CUIL</label>
                    <input
                        type="text"
                        className="form-control"
                        name="cuil"
                        value={alumno.cuil}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="mb-3">
                    <label className="form-label">Fecha de Nacimiento</label>
                    <input
                        type="date"
                        className="form-control"
                        name="fecha_nacimiento"
                        value={alumno.fecha_nacimiento}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="mb-3">
                    <label className="form-label">Curso/División</label>
                    <input
                        type="text"
                        className="form-control"
                        name="curso_division"
                        value={alumno.curso_division}
                        onChange={handleChange}
                        required
                    />
                </div>
                <button type="submit" className="btn btn-success">Guardar</button>
                <button type="button" className="btn btn-secondary ms-2" onClick={() => navigate("/home")}>
                    Cancelar
                </button>
            </form>
        </div>
    );
};

export default NuevoAlumno;
