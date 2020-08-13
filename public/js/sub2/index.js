import store from "./store";
import $ from '../jquery/jquery-3.5.0.min';
import { render } from "./renderer";

function event(){
	$(document)
		.on("scroll",() => {
			console.log(window.scrollY,"#1");
			store.commit('scroll', window.scrollY);
			if( $(document).height() === window.scrollY + window.innerHeight ){
				render(store.state.items);
			}
		})
		.on("click",".open",() => {
			render(store.state.items);
			store.commit('button', true);
		})
}

window.onload = async _ => {
	try {
		await store.loadItems();
		const {scrollData, buttonData} = store.state;
		window.scrollTo(0, scrollData);

		render(
			buttonData
				? store.state.items
				: store.getItemsSplice(10)
		);

		event();

	} catch (e) {
		$("#sub2").html(e);
	}
}