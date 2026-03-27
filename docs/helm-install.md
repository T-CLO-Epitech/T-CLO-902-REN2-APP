# Deploy (local Minikube) + Docker Hub image

## App image (Docker Hub)

Image used by the chart:
- `roronoha69/sample-app-master:latest`

Build + push (recommended multi-arch):
```sh
cd T-CLO-902-REN2-APP/sample-app-master
docker login
docker buildx build --platform linux/amd64,linux/arm64 --push -t roronoha69/sample-app-master:latest .
```

## MySQL (Helm chart, no custom DB chart)

We deploy MySQL with `groundhog2k/mysql` and config in `sample-app-master/helm/db/mysql-values.yaml`.

```sh
helm repo add groundhog2k https://groundhog2k.github.io/helm-charts/
helm repo update
helm upgrade --install mysql groundhog2k/mysql -f T-CLO-902-REN2-APP/sample-app-master/helm/db/mysql-values.yaml
kubectl get pods -l app.kubernetes.io/instance=mysql
kubectl get svc mysql
```

## App (our Helm chart)

```sh
helm upgrade --install my-app T-CLO-902-REN2-APP/sample-app-master/helm/app
kubectl rollout status deploy/my-app
kubectl get pods -l app.kubernetes.io/instance=my-app
kubectl get svc my-app
```

Test locally:
```sh
kubectl port-forward svc/my-app 8080:80
curl -I http://localhost:8080
```

## Screens (proof)

- Docker Hub: repository page showing `roronoha69/sample-app-master:latest`
- Terminal: `helm list`
- Terminal: `kubectl get pods` (mysql + my-app)
- Browser/curl: `http://localhost:8080`

