// product.service.ts

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Product } from '../Models/product';

@Injectable({
  providedIn: 'root'
})
export class ProductService {
  private apiBaseUrl = 'http://your-api-url-here';

  constructor(private http: HttpClient) { }

  getProducts() {
    return this.http.get(`${environment.apiUrl}/products`);
  }

  createProduct(product: Product) {
    return this.http.post(`${environment.apiUrl}/products`, product);
  }
}
