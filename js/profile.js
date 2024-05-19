function estimateSize(size) {
  let chart = {
    XXXS: [76, 81],
    XXS: [81, 86],
    XS: [86, 91],
    S: [91, 96],
    M: [96, 101],
    L: [101, 106],
    XL: [106, 111],
    XXL: [111, 116],
    XXXL: [106, 111],
  }
  let keys = Object.keys(chart)
  for (let i = 0; i < keys.length; i++) {
    let [x, y] = chart[keys[i]]
    if (size['chest-size'] >= x && size['chest-size'] <= y) {
      console.log(x, y, keys[i])
      document.querySelector('.estimate-size').innerHTML = `
      <p class="text-3xl font-medium text-rose-600">${keys[i]}</p>
      <p>we have estimate , your size as ${keys[i]} </p>
      `
      return true
    }
  }
  chart = {
    XXXS: [36, 37],
    XXS: [37, 38],
    XS: [38, 40],
    S: [40, 42],
    M: [43, 44],
    L: [45, 46],
    XL: [47, 48],
    XXL: [49, 51],
    XXXL: [51, 53],
  }
  keys = Object.keys(chart)
  for (let i = 0; i < keys.length; i++) {
    let [x, y] = chart[keys[i]]
    if (size['neck-size'] >= x && size['neck-size'] <= y) {
      console.log(x, y, keys[i])
      document.querySelector('.estimate-size').innerHTML = `
      <p class="text-3xl font-medium text-rose-600">${keys[i]}</p>
      <p>we have estimate , your size as ${keys[i]} </p>
      `
      return true
    }
  }
  console.log('please retake your size tutorial')
  document.querySelector('.estimate-size').innerHTML = `
  <p>it's looks like you have filled incorrect value, retake the size tutorial.</p>
  <a href="profiler.php">
    <button class="border rounded-md shadow-md p-3 text-rose-600">retest</button>
  </a>
  `
  return false
}
let profile = {}
let measurements = [
  'neck-size',
  'chest-size',
  'waist-size',
  'hip-size',
  'shirt-length',
  'shoulder-width',
  'arm-length',
  'wrist-size',
  'leg-size',
]
let measurements2 = [...measurements]
measurements2.splice(0, measurements.length - 1).forEach((el) => {
  console.log(el)
  gsap.to(`.${el}`, {
    opacity: 0,
  })
})
console.log(measurements)
let itr = measurements.length - 1
measurements.forEach((el) => {
  let x = document.querySelector(`.${el} form`)
  x.addEventListener('submit', function () {
    itr--
    let data = new FormData(this)
    let [key, value] = data
    profile[key[0]] = key[1]
    console.log(profile)
    // move to next step
    gsap.to(`.${el}`, {
      zIndex: -1,
      opacity: 0,
    })
    console.log(measurements[itr])
    gsap.to(`.${measurements[itr]}`, {
      zIndex: 100,
      opacity: 1,
    })
    if (el === 'neck-size') estimateSize(profile)
  })
})
document.querySelectorAll('div[data]').forEach((el) => {
  el.addEventListener('click', function (e) {
    document
      .querySelectorAll('div[data]')
      .forEach((el2) =>
        el2 !== this ? el2.classList.remove('bg-stone-200') : '',
      )
    this.classList.toggle('bg-stone-200')
    profile.bodyType = this.innerText
    console.log(profile)
  })
})
document
  .querySelector('input[name="height"]')
  .addEventListener('keyup', function () {
    profile.height = this.value
  })

document.querySelector('form.body-height'),
  addEventListener('submit', function (e) {
    e.preventDefault()
    // move to next step
    gsap.to('div.body-height', {
      zIndex: -1,
      opacity: 0,
    })
  })

document
  .querySelector('.body-type button')
  .addEventListener('click', function () {
    gsap.to('div.body-type', {
      zIndex: -1,
      opacity: 0,
    })
    document.querySelector('.body-size').classList.remove('hidden')
  })
