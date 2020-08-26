import $ from '../jquery/jquery-3.5.0.min';
import xml from './xml';
import store from './store';

export const render = () => {
  const { page, itemCount, type } = store.state;
  const xmlData = xml.getData()
                     .slice()
                     .splice(page * itemCount, itemCount);

  type === 'basic'
    ? renderBasic(xmlData)
    : renderList(xmlData);

  renderNation();
}

const renderBasic = data => {
  const basic = $(".basic");
  const lastBasic = basic.find(".last-list");

  basic
    .css({ display: "block" })
      .siblings()
      .css({ display: "none" })
      .end()
    .find(".all-list").html(data.map(({ no, images, sn, nm, dt }) => `
      <div class="item" data-idx="${no}">
        <div class="imageBox" data-len="${images.length}">
          <img src="/xml/images/${sn}_${no}/${images[0]}" alt="No Image">
        </div>
        <p class="title">${nm}</p>
        <p class="date">${dt}</p>
      </div>
    `))

  const lastItem = basic.find('.all-list .item:last-child');
  lastBasic.html(lastItem.html())
           .attr('data-idx', lastItem.data('idx'))
}

const renderList = data => {
  $(".list")
    .css({ display: "block" })
      .siblings()
      .css({ display: "none" })
      .end()
    .find(".list-wrap")
    .html(data.map(({ no, nm, dt, area }) => `
      <tr class="item" data-idx="${no}">
        <td>${no}</td>
        <td>${nm}</td>
        <td>${dt}</td>
        <td><button>${area}</button></td>
      </tr>
    `));
}

const renderNation = () => {
  const { itemCount, page } = store.state;
  const len = xml.getData().length;
  const pageCut = Math.ceil(len / itemCount);
  $(".page_nation .btn-wrap")
    .html([ ...Array(pageCut).keys() ].map(v => `
      <button${v === page ? ' class="active"' : ''}>${v + 1}</button>
    `))
}