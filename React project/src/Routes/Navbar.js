import { useEffect, useState } from 'react';
import $ from 'jquery';
import axios from 'axios'
import { useQuery } from "react-query"
import { Routes, Route, Link, useNavigate, Outlet } from 'react-router-dom'

import 'bootstrap/dist/css/bootstrap.min.css';
import Nav from 'react-bootstrap/Nav'
import NavDropdown from 'react-bootstrap/NavDropdown'
import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button'
import 'bootstrap/dist/css/bootstrap.min.css';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faShoppingCart } from '@fortawesome/free-solid-svg-icons';


function NavBar() {
    let navigate = useNavigate();
    let [login, setLogin] = useState('off');
    let [toggle, setToggle] = useState('off')
    let result = useQuery('userdata', ()=>{
      return axios.get("https://fhafha28.cafe24.com/JSON/userdata.json")
      .then((a)=>{
        return a.data;
    })
  })
  
    return (
      <>
        <div className='logo'>
          <div className='w70'><h4 className='logo-text' onClick={() => { navigate('/shop') }}>ShoeShop</h4></div>
          <div className='w30'>
            <NavDropdown className='welcome' title={result.isLoading?'Loading':`Hello, ${result.data.name}`} id="basic-nav-dropdown">
              <NavDropdown.Item href="#action/3.1">My page</NavDropdown.Item>
              <NavDropdown.Item href="#action/3.2">
                Notice
              </NavDropdown.Item>
              <NavDropdown.Item href="#action/3.3">Delivery</NavDropdown.Item>
              <NavDropdown.Divider />
              <NavDropdown.Item href="#action/3.4">
                Log out
              </NavDropdown.Item>
            </NavDropdown>
          </div>
        </div>
        <div>
          <div className='w100 btns'>
            <Button className='btn btn-right' variant="secondary" size="sm" onClick={() => { navigate('/cart') }}>
              <FontAwesomeIcon icon={faShoppingCart} /> cart
            </Button>
            <Button className='btn btn-right btn-blue' size="sm" onClick={() => { setToggle("on") }}>
              Log in
            </Button>
            <Button className='btn btn-right' variant="secondary" size="sm" onClick={(e) => {
              let text = $('.serchbar').val();
            }}>
              Search
            </Button>
            <Form.Control className='searchbar' size="sm" type="text" placeholder="Search" />
          </div>
        </div>
      
        <Nav className='font-large'
          activeKey="/home">
          <Nav.Item>
            <Nav.Link href="/shop" className='nav-text'>Home</Nav.Link>
          </Nav.Item>
          <Nav.Item>
            <Nav.Link eventKey="link-1" className='nav-text' onClick={() => { navigate('/About') }}>About</Nav.Link>
          </Nav.Item>
          <Nav.Item>
            <Nav.Link href="/event" className='nav-text'>Event</Nav.Link>
          </Nav.Item>
          <Nav.Item>
            <Nav.Link eventKey="disabled" disabled>
              Disabled
            </Nav.Link>
          </Nav.Item>
        </Nav>
  
        {toggle == 'on' ?
          <>
            <div className="black-bg" id="login">
              <div className="white-bg">
                <h4 className="font-large">Log in</h4>
                <form>
                  <div className="my-3">
                    E-mail
                    <input type="text" className="form-control" id="email"></input>
                  </div>
                  <div className="my-3">
                    Password
                    <input type="password" className="form-control" id="pwd"></input>
                  </div>
                  <button type="submit" className="btn btn-blue" id="send" onClick={
                    (e) => {
                      e.preventDefault();
                      let inputEmail = document.getElementById('email').value;
                      let inputPW = document.getElementById('pwd').value;
                      if (inputEmail == '') {
                        e.preventDefault();
                        alert('write your e-mail');
                      } else
                        if (!/\S+\@\S+\.\S+/.test(inputEmail)) {
                          e.preventDefault();
                          alert('wrong form of e-mail');
                        } else
                          if (inputPW == '') {
                            e.preventDefault();
                            alert('write password');
                          } else
                            if (inputPW.length < 6) {
                              e.preventDefault();
                              alert('Password must be more than 6 characters');
                            }
                            else
                              if (!/[A-Z]+/.test(inputPW)) {
                                e.preventDefault();
                                alert('Password must include uppercase');
                              }
                    }}>Submit</button>
                  <button type="button" className="btn btn-secondary" id="close" onClick={() => { setToggle("off") }}>Close</button>
                </form>
              </div>
            </div>
            <div className="clearbox">
            </div>
          </> : null}
      </>
    )
  }

  export {NavBar};