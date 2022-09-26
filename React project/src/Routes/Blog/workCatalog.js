import { Routes, Route, Link, useNavigate, Outlet } from 'react-router-dom'
import $ from 'jquery';
import axios from 'axios'

function WorkCatalog() {
    let navigate = useNavigate();
    return (
        <div className="blog-card-bg">
            <h4 className='font-title'>Work Catalog</h4>
            <div className="blog-card-container">
                <div className="blog-card-item" onClick={() => navigate('/shop')}>
                    <div style={{ position: "relative" }}>
                        <div className="overlay-wrap">
                            <div className="overlay"><label className="overlay-label">React project. PWA WebApp</label></div>
                        </div>
                        <img src="https://fhafha28.cafe24.com/img/shoeshop.jpg" />
                    </div>
                </div>

                <div className="blog-card-item" onClick={() => { window.location.href = 'https://portfolio-354121.ey.r.appspot.com/' }}>
                    <div style={{ position: "relative" }}>
                        <div className="overlay-wrap">
                            <div className="overlay"><label className="overlay-label">To do App. Node.js server, MongoDB, and Web Socket</label></div>
                        </div>
                        <img src="https://fhafha28.cafe24.com/img/todoapp.jpg" />
                    </div>
                </div>
                <div className="blog-card-item" onClick={() => { window.location.href = 'https://fhafha28.cafe24.com/WebUIShoppingMall.html' }}>
                    <div style={{ position: "relative" }}>
                        <div className="overlay-wrap">
                            <div className="overlay"><label className="overlay-label">UI developing using JavaScript</label></div>
                        </div>
                        <img src="https://fhafha28.cafe24.com/img/webUI.jpg" />
                    </div>
                </div>
                <div className="blog-card-item" onClick={() => { window.location.href = 'https://fhafha28.cafe24.com/LandingPage.html' }}>
                    <div style={{ position: "relative" }}>
                        <div className="overlay-wrap">
                            <div className="overlay"><label className="overlay-label">Landing page</label></div>
                        </div>
                        <img src="https://fhafha28.cafe24.com/img/webUI.jpg" />
                    </div>
                </div>
            </div>
        </div>
    )

}

export { WorkCatalog };