import { useMemo, useState } from 'react';
import $ from 'jquery';
import 'bootstrap/dist/css/bootstrap.min.css';
import axios from 'axios'
import Card from 'react-bootstrap/Card';
import Button from 'react-bootstrap/Button'
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux"
import { plusCount, minusCount, deleteItem } from './../store.js'



function Cart() {
    let navigate = useNavigate();
    let action = useSelector((state) => { return state })
    let dispatch = useDispatch();
    let checked = [];
    let sum = 0;
    action.cart.forEach((a) => {
        sum = sum + a.price * a.count; 
    });
    




    return (
        <>
            <div className="container cart-container">
                <div><h3 className="cart-title">Your shopping cart</h3></div>
                <div>
                    <table className="cart-table">
                        <thead>
                            <tr>
                                <td colSpan="5" >ITEM</td>
                                <td>AMOUNT</td>
                                <td>PRICE</td>
                                <td colSpan="2" >TOTAL</td>
                            </tr>
                        </thead>
                        <tbody>
                            {action.cart.map(function (k, i) {
                                return (<>
                                    <tr>
                                        <td rowSpan="2" className="checkbok" ><input type="checkbox" id={k.id} name="chk[]" onClick={() => {
                                            { checked.push(k.id) }
                                        }}></input></td>
                                        <td rowSpan="2" ><img src={'https://fhafha28.cafe24.com/img/product' + (k.id) + '.jpg'} className="cart-img" /></td>
                                        <td colSpan="3" className="cart-item">{k.name}</td>
                                        <td rowSpan="2" >
                                            <button className='btn-count' onClick={() => {
                                                dispatch(minusCount(i))
                                            }}>-</button>
                                            {k.count}
                                            <button className='btn-count' onClick={() => {
                                                dispatch(plusCount(i))
                                            }}>+</button></td>
                                        <td rowSpan="2" >{k.price}</td>
                                        <td className="cart-boldPrice" rowSpan="2">{(k.price) * (k.count)}</td>
                                    </tr>
                                    <tr className="row-line">
                                        <td className="cart-detail">{`Size: ${k.size}`}</td>
                                    </tr>
                                </>
                                )
                            })}
                            <tr >
                                <td colSpan="7" className="cart-boldPrice" >\</td>
                                <td colSpan="7" className="cart-boldPrice" >{sum}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <div className="w-50"><a href="https://google.com" className="w-50 cart-edit">Edit your shopping cart</a></div>
                    <Button className="btn btn-right" variant="danger" onClick={() => {
                        dispatch(deleteItem(checked))
                    }}>Delete</Button>
                    <Button className="btn btn-right" variant="secondary">Purchase</Button>
                    <div className="clearBoth"></div>
                    <div> <Button className="btn cart-btn-pay" variant="secondary">Choose payment method</Button> </div>
                    <div className="clearBoth"></div>
                </div>
            </div>
            <div style={{ height: "100px" }}></div>

            <div className="container">
                <div className="shop-frame">
                    <h4 className="font-large">Recently viewed</h4>
                    {localStorage.getItem('history') != undefined ? JSON.parse(localStorage.getItem('history')).map(
                        (a, i) => {
                            return (
                                <Card className="shop-item" onClick={
                                    () => { navigate('/detail/' + a.id); }}>
                                    <Card.Img className="item-img" variant="top" src={'https://fhafha28.cafe24.com/img/product' +
                                        a.id + '.jpg'} />
                                    <Card.Body>
                                        <Card.Title>{a.title}</Card.Title>
                                        <Card.Text>
                                            {a.price}
                                        </Card.Text>
                                    </Card.Body>
                                </Card>
                            )
                        }) : <p>no data</p>
                    }
                    <div className="clearBoth"></div>
                    <button className="btn btn-grey" onClick={() => {
                        window.scrollTo(0, 0);
                    }}>TOP</button>
                </div>
            </div>


        </>
    )
}

export default Cart;