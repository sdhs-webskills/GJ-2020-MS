let xml,
  main = {
    type: "basic",
    itemCount: 6,
    page: 0,
    cut: 0
  };

const init = (async _ => {
  const text = await fetch("/xml/festivalList.xml").then(v => v.text());
  xml = [...$($.parseXML(text)).find("item")].map(v => {
    return [...v.children].reduce((acc, v, idx) => {
      const { tagName, children, textContent } = v;
      acc[v.tagName] = tagName === "images" ?  [...children].map(v => v.textContent) :
                       tagName === "sn"     ?  `00${textContent}`.substr(-3) :
                       textContent;
      return acc;
    }, {});
  });
  event();
  renderType();
  renderNation();
});

function event() {
  $(document)
    .on("click", ".typeBtn .btn", ListType)
    .on("click", ".page_nation .btn-wrap button", PageChange)
    .on("click", ".page_nation .arrow", nationArrow)
    .on("click", ".item>*", popup)
    .on("click", ".popup-view .bullet .arrow", bulletArrow)
    .on("click", '.popup-view .btn-wrap button', bulletButton)
    .on("click", ".popup-view .del", _ => $(".popup").css({display: "none"}))
}

function ListType() {
  main.type = $(this).data("type");
  main.page = 0;
  switch (main.type) {
    case "basic":
      main.itemCount = 6;
      break;
    case "list":
      main.itemCount = 10;
      break;
  }
  renderType();
  renderNation();
}

function renderType() {
  let
    basic = $(".basic"),
    last_basic = basic.find(".last-list"),
    list = $(".list"),
    text = [...xml].splice(main.page * main.itemCount, main.itemCount).map(({sn, no, nm, images, cn, dt, area}) => main.type == "basic" ?
      `<div class="item" data-idx="${no}">
		<div class="imageBox" data-len="${images.length}">
		<img src="http://localhost/xml/images/${sn}_${no}/${images[0]}" alt="No Image">
		</div>
		<p class="title">${nm}</p>
		<p class="date">${dt}</p>
		</div>` :
      `<tr class="item" data-idx="${no}">
		<td>${no}</td>
		<td>${nm}</td>
		<td>${dt}</td>
		<td><button>${area}</button></td>
		</tr>`);
  switch (main.type) {
    case "basic":
      last_basic.attr("data-idx", xml[xml.length - 1].no);
      last_basic.find("img").attr("src", `http://localhost/xml/images/${xml[xml.length - 1].sn}_${xml[xml.length - 1].no}/${xml[xml.length - 1].images[0]}`);
      last_basic.find("h3").text(xml[xml.length - 1].nm);
      last_basic.find("p").text(xml[xml.length - 1].cn);
      last_basic.find(".date").text(xml[xml.length - 1].dt);

      basic.css({display: "block"}).siblings().css({display: "none"});
      basic.find(".all-list").html(text);
      break;
    case "list":
      list.css({display: "block"}).siblings().css({display: "none"});
      list.find(".list-wrap").html(text);
      break;
  }
}

function renderNation() {
  let page_cut = Math.ceil(xml.length / main.itemCount),
    nation_wrap = $(".page_nation .btn-wrap");
  nation_wrap.empty();
  for (let i = 1; i <= page_cut; i++)
    nation_wrap.append(`<button>${i}</button>`);
  nation_wrap.find("button").eq(main.page).addClass("active");
}

function nationArrow() {
  let arrow = $(this).data("arrow");
  switch (arrow) {
    case "prev":
      if (main.page - 1 < 0) {
        return;
      }
      main.page -= 1;
      break;
    case "next":
      if (main.page + 1 > $(".page_nation .btn-wrap button").length - 1) {
        return;
      }
      main.page += 1;
      break;
  }
  renderType();
  renderNation();
}

function bulletArrow() {
  let arrow = $(this).data("arrow");
  switch (arrow) {
    case "prev":
      if (main.cut - 1 < 0) return;
      main.cut -= 1;
      break;
    case "next":
      if (main.cut + 1 > $(".popup-view .bullet .btn-wrap button").length - 1) return;
      main.cut += 1;
      break;
  }
  $(".popup-view .slide-box").stop().animate({left: -100 * main.cut + "%"}, 1500);
  $(".popup-view .bullet .btn-wrap button").eq(main.cut).addClass('active').siblings().removeClass("active");
}

function bulletButton() {
  main.cut = $(this).index();
  $(".popup-view .slide-box").stop().animate({left: -100 * main.cut + "%"}, 1500);
  $(".popup-view .bullet .btn-wrap button").eq(main.cut).addClass('active').siblings().removeClass("active");
}

function PageChange() {
  main.page = $(this).index();
  $(this).addClass("active").siblings().removeClass("active");
  renderType();
}

function popup(e) {
  e.preventDefault();
  let item_no = $(this).parents(".item").data("idx"),
    data = [...xml].filter(({no}) => no == item_no)[0],
    pv = $(".popup .popup-view"),
    ps = pv.find(".slide-box"),
    pu = pv.find(".bullet .btn-wrap"),
    len = data.images.length - 1;
  main.cut = 0;

  $(".popup").css({display: "flex"});
  pv.find("img").attr("src", `http://localhost/xml/images/${data.sn}_${data.no}/${data.images[0]}`);
  pv.find(".title").text(data.nm);
  pv.find(".area").text(data.area);
  pv.find(".content").text(data.cn);
  pv.find(".location").text(data.location);
  pv.find(".date").text(data.dt);

  ps.removeAttr("style");
  ps.css({width: 100 * (len + 1) + "%"});
  ps.html(data.images.map(v => `<div><img src="http://localhost/xml/images/${data.sn}_${data.no}/${v}" alt="No Image" /></div>`));
  pu.html(data.images.map((v, idx) => `<button>${idx + 1}</button>`))
  pu.find("button").eq(0).addClass("active");
}

init();