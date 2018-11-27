ORDERS=1 2 3
create-order-all: $(patsubst %, create-order-%, $(ORDERS))
create-order-%:
	curl -XPOST -d @data/orders/order$*.json -H "Accept: application/json" -H "Content-Type: application/json" http://localhost:3000/order
