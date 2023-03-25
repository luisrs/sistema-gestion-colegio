import React, { useState } from 'react';
import Swal from 'sweetalert2'
import axios from 'axios';

export function Table({data}){

    const [listaAlumnos, setlistaAlumnos] = useState(data.alumnos);
    const [listaNotas, setListaNotas] = useState(data.notas);
    // setlistaAlumnos({...listaAlumnos,alumno})
    const handleInputNota = (e) =>{
        const notaId = e.target.getAttribute("data-nota")
        const alumnoId = e.target.getAttribute("data-alumno")
        const porcentaje = e.target.getAttribute("data-porcentaje")
        const notaInput = e.target.value
        
        if(isNotaValida(notaInput)){
            const ponderado = Number((notaInput * (porcentaje)/100)).toFixed(1)
            // Se asigna ponderado a input siguiente
            $(`.${alumnoId}_${notaId}`).val(ponderado);
            pintarInputNota(e, notaInput)

            const nuevasNotas = (listaNotas).map(nota =>{
                if(nota.id == notaId){
                    return {...nota, calificacion : notaInput, ponderado : ponderado}
                }
                return nota
            })
            setListaNotas(nuevasNotas);

            const alumnoSelected = listaAlumnos.find(alumno => alumno.id == alumnoId);
            alumnoSelected.notas = nuevasNotas;
            // Si se ingresaron todas las notas calcular nota final
            if(alumnoSelected.notas.every(nota => nota.calificacion != null)){
                alumnoSelected.notaFinal = alumnoSelected.notas.reduce((acc,nota) =>{
                    return acc + Number(nota.ponderado)
                },0)
                $(`.nota-final-${alumnoId}`).val(alumnoSelected.notaFinal.toFixed(1))
            }

        // Nota inválida
        }else{
            e.target.value = '';
            $(`.${alumnoId}_${notaId}`).val('');
        }  
    }

    const onSubmit =  (e) =>{
        e.preventDefault()
        try {
          const res =  axios.post('http://localhost/f546/public/index.php/registro-notas', {}, {
            params : {
                listaAlumnos
            }
          } ).then((Response)=>{ console.log(response)})
          console.log(res.data)
        } catch (e) {
          alert(e)
        }
    }

    return(
        <form onSubmit={onSubmit}>
        <table className="table table-sm table-bordered ">
            <thead className="bg-primary text-light">
            <tr className="text-center">
                <td colSpan={data.notas.length * 2 + 2} scope="col" >Primer Semestre
                </td>
            </tr>
            <tr className="text-center">
                <td rowSpan={2} scope="col" >Alumno</td>
                {data.notas.map((nota, index) => {
                    if(nota && nota.periodo == 'Primer Semestre'){
                        return <td colSpan={2} key={index} scope="col" >Formativa</td>
                    }       
                })}
                <td rowSpan={2} scope="col" >Nota Final</td>                                               
            </tr>
            <tr className="text-center">
                {data.notas.map((nota,index) => {
                    if(nota){
                    return <>
                        <td key={index} scope='col'>Nota</td>
                        <td key={index+1} scope='col'>{nota.porcentaje}%</td>
                    </>
                    }
                })}
            </tr>

            </thead>
            <tbody>
            {data.alumnos.map((alumno, index) =>  
                 <tr>
                 <td>{alumno.nombre}</td>
                 {data.notas.map((nota,index)=>{
                     if(nota && nota.periodo == 'Primer Semestre'){
                         return <>
                         <td>
                             <input data-alumno={alumno.id} data-nota={nota.id} data-porcentaje={nota.porcentaje} type="text" onChange={handleInputNota} className="form-control"/>
                             </td>
                         <td>
                             <input disabled type="text" className={"form-control " + alumno.id + '_' + nota.id }/>
                         </td>
                         </>
                     }
                 })}
                 <td><input disabled type="text" onChange={handleInputNota} className={`form-control nota-final-${alumno.id}`}/></td>
                </tr>
                )}  
            </tbody>
        </table>
        <button className="btn-flotante">Registrar</button>
        </form>
    )
}


function isNotaValida(notaInput){
    if((notaInput <2 || notaInput > 7) && notaInput != ''){
        Swal.fire({
            icon: 'error',
            title: 'Nota incorrecta',
            text: 'Debe estar entre 2 y 7'
        })
        return false;
    }
    return true;
}

function pintarInputNota(event, nota){
    if(nota <4){
        event.target.classList.add('is-invalid')
    }else{
        event.target.classList.add('is-valid')
        event.target.classList.remove('is-invalid')
    }

}
