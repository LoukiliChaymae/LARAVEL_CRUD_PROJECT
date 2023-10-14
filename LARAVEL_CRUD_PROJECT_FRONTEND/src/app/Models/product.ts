export class Product {
    id: number;
    name: string;
    qty: number;
    price: number;
    description: string;
  
    constructor() {
      this.id = 0; 
      this.name = '';
      this.qty = 0;
      this.price = 0;
      this.description = '';
    }
  }