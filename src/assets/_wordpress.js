export default class WP {
	constructor(base='tnf_name') {
		this.home = `https://namefiles.co/wp-json/wp/v2`
		this.base = base
	}
	json(params) {
		let qs = typeof string === params ? params : this.params(params)
		let url = `${this.home}/${this.base}/?${qs}`
		let json = fetch(url)
			.then(response => response.json())
			.then(data => data)
			.catch(err => console.error('Error: '+ err.message))
		return json
	}
	params(args) {
		let qs = []
		Object.keys(args).forEach(key => {
			let value = args[key]
			key = key.replace(/([A-Z])/g, "_$1").toLowerCase()
			qs.push(`${key}=${value}`)
		})
		return qs.join('&')
	}
}