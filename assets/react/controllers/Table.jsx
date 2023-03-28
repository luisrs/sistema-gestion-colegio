import React, { useContext, useState } from 'react';
import {RegistroNotasContext} from '../context/RegistroNotasContext'
import Row from './Row'

export function Table(){
    
    const {notas,alumnos, onSubmit} = useContext(RegistroNotasContext)
    // const {onSubmit} = useContext(RegistroNotasContext)
    return(
        <form onSubmit={onSubmit}>
        <table className="table table-sm table-bordered ">
            <thead className="bg-primary text-light">
            <tr className="text-center">
                <td colSpan={notas.length * 2 + 2} scope="col" >Primer Semestre
                </td>
            </tr>
            <tr className="text-center">
                <td rowSpan={2} scope="col" >Alumno</td>
                {notas.map((nota, index) => {
                    if(nota && nota.periodo == 'Primer Semestre'){
                        return <td colSpan={2} key={index} scope="col" >Formativa</td>
                    }       
                })}
                <td rowSpan={2} scope="col" >Nota Final</td>                                               
            </tr>
            <tr className="text-center">
                {notas.map((nota,index) => {
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
            {alumnos.map((alumno, index) =>  
                 <Row key={index} alumno = {alumno}/>
                )}  
            </tbody>
        </table>
        <button className="btn-flotante">Registrar</button>
        </form>
    )
}
