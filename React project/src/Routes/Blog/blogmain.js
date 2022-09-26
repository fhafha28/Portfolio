
import { useState } from 'react';
import React from 'react';
import { Routes, Route, Link, useNavigate, Outlet } from 'react-router-dom'
import {Board, Modal} from './board.js';
import {Profile3d} from './3dProfile.js';
import {WorkCatalog} from './workCatalog.js'


function BlogMain() {
  let navigate = useNavigate();
  let [글제목, titleChange] = useState(['Example UI 1', 'Example UI 2', 'Example UI 3'])
  let [title, setTitle] = useState([0])
  let copy = [...글제목]

  return (
    <div className="App">
        
      <div className="black-nav">
        <div className="blognavtitle">AR's Blog</div>
      </div>
      <div className='nav-below'></div>

      <div className='container'>
        <WorkCatalog></WorkCatalog>
        <Board 글제목={글제목} titleChange={titleChange}></Board>
        <Profile3d></Profile3d>
      </div>
    </div>

  );
}


export  {BlogMain};

