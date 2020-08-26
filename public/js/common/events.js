import store from "./store";
import { render } from "./renderer";
import $ from '../jquery/jquery-3.5.0.min';
import xml from './xml';

export const event = () => {
  $(document)
    .on("click", ".typeBtn .btn", ListType)
    .on("click", ".page_nation .btn-wrap button", selectPage)
    .on("click", ".page_nation .arrow", setPageByArrow)
    .on("click", ".item>*", popup)
    .on("click", ".popup-view .bullet .arrow", setCutByArrow)
    .on("click", '.popup-view .btn-wrap button', selectCut)
    .on("click", ".popup-view .del", _ => $(".popup").css({display: "none"}))
}

const ListType = ({ target }) => {
  const type = target.dataset.type;
  store.commit('type', type);
  store.commit('page', 0);
  store.commit('itemCount', { basic: 6, list: 10 }[type]);
  render();
}

const setPageByArrow = ({ target }) => {
  store.commitByArrow(target.dataset.arrow, 'page', $(".page_nation .btn-wrap button").length);
  render();
}

const setCutByArrow = ({ target }) => {
  store.commitByArrow(target.dataset.arrow, 'cut', $(".popup-view .bullet .btn-wrap button").length);
  render();
  activeCut();
}

const selectCut = ({ target }) => {
  store.commit('cut', $(target).index());
  activeCut();
}

const activeCut = () => {
  const { cut } = store.state;
  $(".popup-view .slide-box")
    .stop()
    .animate({left: -100 * cut + "%"}, 1500);

  $(".popup-view .bullet .btn-wrap button")
    .eq(cut)
    .addClass('active')
      .siblings()
      .removeClass("active");
}

const selectPage = ({ target }) => {
  const $target = $(target);
  store.commit('page', $target.index())
  $target.addClass("active")
         .siblings()
         .removeClass("active");

  render();
}

const popup = e => {
  e.preventDefault();
  const itemNo = $(e.target).parents(".item").data("idx");
  const { sn, no, nm, images, area, cn, location, dt } = xml.getData().filter(({ no }) => no === itemNo)[0];
  const popupView = $(".popup .popup-view");
  const slideBox = popupView.find(".slide-box");
  const bullet = popupView.find(".bullet .btn-wrap");
  const len = images.length - 1;

  store.commit('cut', 0);

  $(".popup").css({ display: "flex" });

  popupView
    .find("img").attr("src", `/xml/images/${sn}_${no}/${images[0]}`).end()
    .find(".title").text(nm).end()
    .find(".area").text(area).end()
    .find(".content").text(cn).end()
    .find(".location").text(location).end()
    .find(".date").text(dt);

  slideBox
    .attr("style", `width: ${100 * (len + 1)}%`)
    .html(images.map(v => `<div><img src="/xml/images/${sn}_${no}/${v}" alt="No Image" /></div>`));

  bullet
    .html(images.map((v, idx) => `<button>${idx + 1}</button>`))
      .find("button")
        .eq(0)
        .addClass("active");
}