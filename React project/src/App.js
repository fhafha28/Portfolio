import { lazy, Suspense, useEffect, useState } from 'react';
import $ from 'jquery';
import axios from 'axios'
import { useQuery } from "react-query"
import { Routes, Route, Link, useNavigate, Outlet } from 'react-router-dom'
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';

import Data from './Routes/data.js';

import { Mainpage } from './Routes/mainpage.js';
import { NavBar } from './Routes/Navbar.js'
import { About } from './Routes/About.js'
import { BlogMain } from './Routes/Blog/blogmain.js'


const Cart = lazy(() => import('./Routes/cart.js'))
const Event = lazy(() => import('./Routes/Event.js'))
const Detail = lazy(() => import('./Routes/detail.js'))



function App() {
  let [shoes, setShoes] = useState(Data);
  let navigate = useNavigate();
  let [글제목, titleChange] = useState(['Example UI 1', 'Example UI 2', 'Example UI 3']);
  let [title, setTitle] = useState([0]);
  let copy = [...글제목];


  return (
    <div className="App">

      <Suspense fallback={
        <div className="position-center loading">
          <i className="fa-solid fa-face-smile"></i>
          <p>Loading</p>
        </div>}>
        <Routes>
          <Route path='/' element={
            <><BlogMain></BlogMain></>
          }></Route>
          <Route path='/shop' element={<Suspense>
            <NavBar />
            <Mainpage shoes={shoes}></Mainpage>
          </Suspense>
          }></Route>
          <Route path='/detail' element={
            <><NavBar /><Detail shoes={shoes} /></>
          }></Route>
          <Route path='/detail/:id' element={<><NavBar /><Detail shoes={shoes} /></>}></Route>
          <Route path='/cart' element={<><NavBar /><Cart /></>
          }></Route>
          <Route path='*' element={<div>No page</div>}></Route>
          <Route path="/About" element={<><NavBar /><About /></>} >
            <Route path="member" element={<div>members</div>} />
            <Route path="location" element={<div>location</div>} />
          </Route>
          <Route path='/event' element={<><NavBar /><Event /></>}>
            <Route path="one" element={<div>Free Cabbage juice for the first order!</div>} />
            <Route path="two" element={<div>Get a birthday coupon!</div>} />
          </Route>
        </Routes>
      </Suspense>

    </div>
  );
}
var 탭UI = {
  info: <p>상품정보</p>,
  shipping: <p>배송관련</p>,
  refund: <p>환불약관</p>
}

function Component() {
  var 현재상태 = 'info';
  return (
    <div>
      {
        탭UI[현재상태]
      }
    </div>
  )
}




export default App;
