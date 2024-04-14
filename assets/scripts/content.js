
function readingTime(obj) {
	var objID = obj.id;
	if (objID) {
		const estimateContainer = document.getElementById(objID);
		if (estimateContainer) {
			let time;
			const text = estimateContainer.querySelector(".estimate").innerText;
			const wpm = 225;
			const words = text.trim().split(/\s+/).length;
			time = Math.ceil(words / wpm);
			let readingTimeObj = estimateContainer.querySelector(".read-time");
			if (readingTimeObj) readingTimeObj.innerText = time + ' min read';
		}
	}
}

const contentSlider = document.querySelector(".content-slider ");
if (contentSlider) {
	var contentslidesThatArePosts = document.querySelectorAll(".type-post");

	contentslidesThatArePosts.forEach(function (contentslideThatIsPost) {
		readingTime(contentslideThatIsPost);
	});
}
const readTimes = document.querySelectorAll(".read-time");
if (readTimes) {
	const contentLoop = document.querySelector('.content-loop')
	if (contentLoop) {
		const contentLoopPosts = contentLoop.querySelectorAll('.card');
		contentLoopPosts.forEach(function (contentLoopPost) {
			readingTime(contentLoopPost);
		});
	}
}

const articleInteriorPage = document.querySelector(".supply-articles");
const sidebar = document.querySelector(".sidbar-meta");




function copyLink() {
	if (!window.getSelection) {
		alert('Please copy the URL from the location bar.');
		return;
	}
	const toasts = document.querySelectorAll('.liveToast')
	// const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
	const dummy = document.createElement('p');
	dummy.textContent = window.location.href;
	document.body.appendChild(dummy);

	const range = document.createRange();
	range.setStartBefore(dummy);
	range.setEndAfter(dummy);

	const selection = window.getSelection();
	// First clear, in case the user already selected some other text
	selection.removeAllRanges();
	selection.addRange(range);

	document.execCommand('copy');
	document.body.removeChild(dummy);
	toasts.forEach(function (toast) {
		toast.classList.add('fade-in-bottom', 'show');
		if (toast.classList.contains('fadeout')) {
			toast.classList.remove('fadeout');
		}
		const callback = () => {
			toast.classList.remove('show');
			window.removeEventListener('scroll', callback);
		}

		window.addEventListener('scroll', callback);       // add scroll event listener


		setTimeout(
			function () {
				toast.classList.add('fadeout');
				setTimeout(
					function () {
						toast.classList.remove('show');
					}, 700);
			}, 7000);
	});
}

const shareLinks = document.querySelectorAll(".copy-to-clipboard");
shareLinks.forEach(function (shareLink) {
	if (shareLink) {

		shareLink.addEventListener("click", (e) => {
			e.preventDefault();
			copyLink();
		});
	}
});

function get_stats() {
	let statsBlock = document.querySelector('.stats-block');

	function statsLoadingAnimation() {


		//if (statsBlock.classList.contains('animation')) {
		let stats = statsBlock.querySelectorAll('.stats'),
			timerCount = 0;
		let observer = new MutationObserver(function (mutations) {
			mutations.forEach(function (mutation) {
				if (mutation.attributeName == "class") {
					var containerAnimated = mutation.target.classList.contains('animate');
					if (containerAnimated) {
						stats.forEach(function (stat) {
							let statNumber = stat.dataset.stat;
							setTimeout(() => {
								cashregister(stat, statNumber)
							}, timerCount);

							timerCount++;
						});
						observer.disconnect();
					}

				}
			});
		});

		if (statsBlock.classList.contains('fold')) {
			observer.observe(statsBlock, {
				attributes: true
			});
		} else {
			stats.forEach(function (stat) {
				let statNumber = stat.dataset.stat;
				cashregister(stat, statNumber)

			});
		}
		function cashregister(elem, num) {
			var output = elem.innerHTML;

			function intervalfunc(interval, num) {
				var end = parseInt(num);
				var cont = parseInt(elem.innerHTML);

				elem.innerHTML = cont + interval;
				if (elem.innerHTML == num) {
					clearInterval(int);
					return false;
				}
			}

			if (num > output) {
				var int = setInterval(function () {
					intervalfunc(1, num);
				}, 0.1);
			} else if (num < output) {
				var int = setInterval(function () {
					intervalfunc(-1, num);
				}, 0.1);
			} else if (num == elem.innerHTML) {
				// do nothing
			}
		}

	}

	if (statsBlock) {
		statsLoadingAnimation();
	}
}
get_stats();
export { get_stats }