import $ from '../jquery/jquery-3.5.0.min'
import store from './store';

export const render = () => {
  const { items } = store.state;
	$(".list").html(items.map(renderList));
}

export const renderByData = data => {
  $(".list").html(data.map(renderList));
}

const renderList = () => ({ bkpr, cur_nm, cur_unit, deal_bas_r, kftc_bkpr, kftc_deal_bas_r, result, ten_dd_efee_r, ttb, tts, yy_efee_r }) => `
  <tr ${ result === 0 ? "class=active" : "" }>
    <td>${result}</td>
    <td>${cur_unit}</td>
    <td>${ttb}</td>
    <td>${tts}</td>
    <td>${deal_bas_r}</td>
    <td>${bkpr}</td>
    <td>${yy_efee_r}</td>
    <td>${ten_dd_efee_r}</td>
    <td>${kftc_bkpr}</td>
    <td>${kftc_deal_bas_r}</td>
    <td>${cur_nm}</td>
  </tr>`