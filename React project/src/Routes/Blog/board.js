import { useState } from 'react';
function Board(props) {

    let [like, likeChange] = useState([0, 0, 0])
    let [modal, setModal] = useState(false);
    let [title, setTitle] = useState([0])
    let [input, setInput] = useState('');
    let [date, setDate] = useState(
      ['Feb 17 2022', 'Mar 17 2022', 'Mar 23 2022'])
  
    function change() {
      let copy = [];
      copy[0] = 'changed to this'
      props.titleChange(copy);
    }
    const nameAscending = () => {
      let copy = [];
      copy.sort();
      props.LinktitleChange(copy);
    }
  
    return (
      <>
        <div className='board'>
          <div className='board-head'>
            <h4 className='font-title'>Board</h4>
            <button className='btn btn-blog btn-right' onClick={change}>Edit</button>
            <button className='btn btn-blog btn-right' onClick={nameAscending}>abc</button>
            <div style={{ clear: 'both' }}></div>
          </div>
          {
            props.글제목.map(function (a, i) {
              return (
                <div className='blog-list' key={i} >
                  <div className='blog-list-item'>
                    <h4 className='font-md' onClick={() => { setModal(1); setTitle(i) }}>{a}
                      <span className='like' onClick={(e) => {
                        e.stopPropagation();
                        let copy = [...like];
                        copy[i] = copy[i] + 1;
                        props.likeChange(copy)
                      }} key={i}> ❤</span> {like[i]}</h4>
                    <p className='font-sm' id="post-date">{date[i]}</p>
                    <button className='btn btn-blog btn-blog-list' onClick={(e) => {
                      let copy = [...props.글제목];
                      copy.splice(a, 1);
                      props.titleChange(copy);
                    }}>Delete</button>
                  </div>
                </div>)
            })}
  
          <div style={{ clear: 'both', margin: '15px' }}></div>
        </div>
        
          {modal == 1 ? <Modal 글제목={props.글제목} title={title} change={change}></Modal> : null}

          <input type="text" onChange={(e) => {
            setInput(e.target.value);
          }}></input> 
          <button className='btn-blog blog-btn-post' onClick={() => {
            if (input !== '') {
              let copy = [...props.글제목], copyLike = [...like];
              copy.unshift(input); copyLike.unshift(0);
              props.titleChange(copy); likeChange(copyLike);
            }
            let copyDate = [...date];
            let now = Date()
            let postDate = now.slice(4, 15);
            copyDate.unshift(postDate);
            setDate(copyDate);
          }}>Post</button>
          <div className='nav-below'></div>


      </>
    )
  }
  
  
  function Modal(props) {
    return (
      <div className='modal'>
        <h4>{props.글제목[props.title]}</h4>
        <p>Date</p>
        <p>Detail</p>
        <button className=' btn btn-blog' onClick={props.change}>Edit</button>
      </div>
    )
  }
  
  export {Board, Modal}