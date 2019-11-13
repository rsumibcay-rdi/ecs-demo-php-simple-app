function goodbye_modal(e) {
	var t = e.target || e;
	t.classList.contains("video-modal") && (stop_playing(t), t.classList.remove("active"), t.removeEventListener("click", goodbye_modal), document.removeEventListener("keyup", goodbye_all_modals))
}

function goodbye_all_modals(e) {
	switch (e.which || e.keyCode || 0) {
		case 27:
		case 88:
		case 81:
		case 8:
			goodbye_modal(document.querySelector(".video-modal.active"))
	}
}

function stop_playing(e) {
	var t = e.querySelector("iframe");
	t.setAttribute("src", t.getAttribute("src"))
}

document.addEventListener("DOMContentLoaded", function() {
	function e(e, t, n) {
		var i = t.querySelector(".is-selected");
		i && i.classList.remove("is-selected"), e.classList.add("is-selected"), Flickity.data(n).select(Array.prototype.indexOf.call(e.parentNode.children, e), !1, !1)
	}

	function t(e, t) {
		var n = Flickity.data(e);
		n.on("select", function() {
			var e = t.children,
				i = t.querySelector(".is-selected");
			i && i.classList.remove("is-selected"), e[n.selectedIndex].classList.add("is-selected")
		})
	}
	if ("undefined" != typeof Flickity) {
		for (var n = document.querySelectorAll(".caret-slider__icons"), i = 0; i < n.length; i++) {
			Flickity.data(n[i]).on("staticClick", function(e, t, n, i) {
				n && this.select(i, !1, !1)
			})
		}
		for (var a = document.querySelectorAll(".overview-slider__nav"), i = 0; i < a.length; i++) a[i].firstChild.classList.add("is-selected"), a[i].addEventListener("click", function(t) {
			var n = t.target;
			"IMG" === t.target.nodeName && (n = t.target.parentNode), e(n, this, n.parentNode.previousElementSibling)
		});
		for (var s = document.querySelectorAll(".overview-slider__slider"), i = 0; i < s.length; i++) t(s[i], s[i].nextElementSibling)
	}
});
